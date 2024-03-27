## u10 Test

### Логіка

1. Звернення до API за маршрутом `/api/parcel/create` та передача даних, котрі потрапляють до маршрутизатора

```php
Route::prefix('parcel')->group(function () {
    Route::post('/create', [\App\Http\Controllers\ParcelController::class, 'create']);
});
```

2. З маршрутизатора дані потрапляють до контролера посилки (`ParcelController.php`) та передаються до сервісу
   посилки (`ParcelService.php`)

```php
class ParcelController extends Controller
{
    private ParcelService $parcelService;

    public function __construct(ParcelService $parcelService)
    {
        $this->parcelService = $parcelService;
    }

    public function create(ParcelRequest $request)
    {
        return $this->parcelService->create($request);
    }
}
```

3. У сервісі посилки (`ParcelService.php`) спочатку данні проходять валідацію (`ParselRequst.php`), потім передаються до
   поштового сервісу (`PostService.php`), який повертає поштовий сервіс (у нашому випадку це нова
   пошта (`NovaPostService.php`) або укр пошта (`UkrPostService.php`)), що вказаний в запиті полем (`post_service`), для
   подальших маніпуляцій з даними у поштовому сервісі (`NovaPostService.php` або `UkrPostService.php`), якщо у даних
   вказаний поштовий сервіс, який не існує повертається відповідна
   помилка (`response()->json(['ok' => false, 'message' => 'Post service not found']);`)

```php
class ParcelService extends Service
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function create(ParcelRequest $request)
    {
        $validated = $request->validated();

        $postService = $this->postService->get($validated['post_service']);

        if (!$postService) {
            return response()->json(['ok' => false, 'message' => 'Post service not found']);
        }

        return $postService->create($validated);
    }
}
```

4. Валідація даних (`ParcelRequest.php`), якщо дані не вірні повертається
   помилка (`throw new HttpResponseException(response()->json($validator->errors(), 422));`)

```php
class ParcelRequest extends Request
{
    public function rules(): array
    {
        return [
            'sender_name' => 'required|string',
            'sender_address' => 'required|string',
            'receiver_name' => 'required|string',
            'receiver_address' => 'required|string',
            'parcel_name' => 'required|string',
            'parcel_weight' => 'required|numeric',
            'post_service' => 'required|string',
        ];
    }
}
```

5. Отримання поштового сервісу (`PostService.php`), через поле (`post_service`) у запиті

```php
class PostService extends Service
{
    private array $postServices;

    public function __construct(NovaPostService $novaPostService, UkrPostService $ukrPostService)
    {
        $this->postServices = [
            'novapost' => $novaPostService,
            'ukrpost' => $ukrPostService,
        ];
    }

    public function get($service)
    {
        return $this->postServices[$service] ?? null;
    }
}
```

6. Створення посилки у API NovaPost через сервіс (`NovaPostService.php`)

```php
class NovaPostService extends Service
{
    public function create($validated): JsonResponse
    {
        // create parcel API NovaPost

        return response()->json(['ok' => true, 'data' => $validated]);
    }
}
```

7. Створення посилки у API UkrPost через сервіс (`UkrPostService.php`)

```php
class UkrPostService extends Service
{
    public function create($validated): JsonResponse
    {
        // create parcel API UkrPost

        return response()->json(['ok' => true, 'data' => $validated]);
    }
}
```

### Додавання нового сервісу пошти

1. Створити сервіс (клас `PHP` за шляхом `app/Services`)

```php
class NewService extends Service
{
    public function create($validated): JsonResponse
    {
        // create function
    }
}
```

2. Додати створений сервіс у поштовому сервісі (`PostService.php`)

```php
class PostService extends Service
{
    public function __construct(NovaPostService $novaPostService, UkrPostService $ukrPostService, NewService $newService)
    {
        $this->postServices = [
            'novapost' => $novaPostService,
            'ukrpost' => $ukrPostService,
            
            // add new service here
            
            'new' => $newService,
        ];
    }
}
```

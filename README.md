
# Zoom Demo

Zoom is one of the popular group video applications used by many users worldwide. So many projects want integration with Zoom this demo gives laravel integration with zoom

## Installation

First Zoom has some dependencies that import to use and it is an easy way to use it. 

```bash
composer require firebase/php-jwt
composer require guzzlehttp/guzzle
```
And Now run
```bash
 composer update
```
And don't forget that we also need to modify .env files to set the zoom API credentials.
```
ZOOM_API_URL="https://api.zoom.us/v2/"
ZOOM_API_KEY="INPUT_YOUR_ZOOM_API_KEY"
ZOOM_API_SECRET="INPUT_YOUR_ZOOM_API_SECRET"
```
You can find the zoom credentials from your zoom app.
## Usage
Now create a new trait for it.
And just copy form the below code
```php
 // intial variable for all function use
    public $client;
    public $jwt;
    public $headers;
    public $meetingtype = 2;
    public $host_video = 1;
    public $participant_video = 1;

    public function __construct()
    {
        //define value for all functions
        $this->client = new Client();
        $this->jwt = $this->generateZoomToken();
        $this->headers = [
            'Authorization' => 'Bearer '.$this->jwt,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }

    public function generateZoomToken()
    {
        $key = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];
        // create an new jwttoken for zoom api
        return \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
    }

    private function retrieveZoomUrl()
    {
        // give env file for api base url
        return env('ZOOM_API_URL', '');
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        // get date and convert into the correct date which is need to zoom api
        try {
            $date = new \DateTime($dateTime);
            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : '.$e->getMessage());
            return '';
        }
    }

    public function createmeeting($data)
    {
        $path = 'users/me/meetings';
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([
                'topic'      => $data['topic'],
                'type'       => $this->meetingtype,
                'start_time' => $this->toZoomTimeFormat($data['start_time']),
                'duration'   => $data['duration'],
                'agenda'     => (! empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone'     => 'Asia/Kolkata',
                'settings'   => [
                    'host_video'        => ($this->host_video == "1") ? true : false,
                    'participant_video' => ($this->participant_video == "1") ? true : false,
                    'waiting_room'      => true,
                ],
            ]),
        ];

        $response =  $this->client->post($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 201,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function updatemeeting($id, $data)
    {

        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([
                'topic'      => $data['topic'],
                'type'       => $this->meetingtype,
                'start_time' => $this->toZoomTimeFormat($data['start_time']),
                'duration'   => $data['duration'],
                'agenda'     => (! empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone'     => 'Asia/Kolkata',
                'settings'   => [
                    'host_video'        => ($this->host_video == "1") ? false : true,
                    'participant_video' => ($this->participant_video == "1") ? false : true,
                    'waiting_room'      => true,
                ],
            ]),
        ];
        $response =  $this->client->patch($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function getmeeting($id)
    {
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();
        $this->jwt = $this->generateZoomToken();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
        ];

        $response =  $this->client->get($url.$path, $body);
        return [
            'success' => $response->getStatusCode() === 200,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    /**
     * @param string $id
     *
     * @return bool[]
     */
    public function deletemeeting($id)
    {
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
        ];

        $response =  $this->client->delete($url.$path, $body);
        return view('welcome');
        
    }

```
use trait function we need to import in the controller adding these two-line at the controller.
```PHP
use App\Traits\zoommeetingTrait;
class ZoomController extends Controller
{
  use zoommeetingTrait; //use for zoom trait function
  ...
}
```
you can call the function using a controller like the below example.
```PHP
 public function store(Request $request)
    {
        $request->validate([
            'topic'         => 'required|string',
            'duration'      => 'required|numeric',
            'start_time'    => 'required',
            'agenda'        => 'required|string|nullable',
        ]);
        
        return $this->createmeeting($request->only('topic','duration','start_time','agenda'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $request->validate([
            'id'            => 'required',
        ]);
        return $this->getmeeting($request->id);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'topic'         => 'required|string',
            'duration'      => 'required|numeric',
            'start_time'    => 'required',
            'agenda'        => 'required|string|nullable',
            'id'            => 'required',
        ]);

        return $this->updatemeeting($request->id, $request->only('topic','duration','start_time','agenda'));
       
    }

    
    public function destroy(Request $request)
    {
        $request->validate([
            'id'            => 'required',
        ]);
        $this->deletemeeting($request->id);
    }
```

##More

[please visit this site for more information about it.](https://marketplace.zoom.us/docs/api-reference/zoom-api)
## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

# [🔗](https://invites-app-mfestrada.vercel.app/) Invites App

This is a simple program that given a lists of affiliates `app/storage/affiliates.txt` displays them into a list, where the user can filter the records according to the location desired (City: Dublin), whitin a range of km (100km).
The aim is to get listed only those whom meet the conditions to send an invitation to an event. :partying_face:

&nbsp; 

###### Exaple of affiliates.txt

```json
{"latitude": "52.3191841", "affiliate_id": 3, "name": "Rudi Palmer", "longitude": "-8.5072391"}
{"latitude": "52.366037", "affiliate_id": 16, "name": "Linzi Carver", "longitude": "-8.179118"}
{"latitude": "52.833502", "affiliate_id": 25, "name": "Tasneem Wolfe", "longitude": "-8.522366"}

```
&nbsp; 

In this case just Rudi, Linzi and Tasneem will get invited since they are within 50 km from Limerick.

![App Screenshot](https://raw.githubusercontent.com/fatimaestrada/invites-app/master/readme/list.png)


The results are based on the data provided (lat, lon) on the affiliates.txt file and calculate the distance with the choosen city coordinates like this:

```php
function calculate_distance($from, $to)
{
    $degtorad = 0.01745329;
    $R = 6372.795477598;

    extract($from, EXTR_PREFIX_ALL, 'from');
    extract($to, EXTR_PREFIX_ALL, 'to');


    // Simple validation of the values to proccess
    if ($from_latitude == null || $from_longitude == null || $to_latitude == null || $to_longitude == null) {
        return null;
    }

    // If the positioning is the same theres no need to do the calculation
    if ($from_latitude === $to_latitude && $from_longitude === $to_longitude) {
        return 0;
    }

    $from_lat = $from_latitude * $degtorad;
    $from_lon = $from_longitude * $degtorad;
    $to_lat = $to_latitude * $degtorad;
    $to_lon = $to_longitude * $degtorad;

    $dist_km = $R * acos(sin($from_lat) * sin($to_lat) + cos($from_lat) * cos($to_lat) * cos($from_lon - $to_lon));

    return $dist_km;
}

```

[Distance Calculation Method used](https://en.wikipedia.org/wiki/Great-circle_distance)


&nbsp; 

&nbsp; 

## 🛠 Getting Started
Build with Laravel + VueJS, deploy to Vercel

To get started with the project, follow the instructions below to set up the application and run it locally.

Prerequisites
- PHP (>= 7.4) and Composer installed on your system.
- Node.js (>= 14.x) and npm installed on your system.


#### Installation

Clone the project

```bash
  git clone git@github.com:fatimaestrada/invites-app.git
```

Go to the project directory

```bash
  cd invites-app
```

Install Laravel backend dependencies

```bash
  composer install
```

Copy the example *.env*  file 
```bash
  cp .env.example .env
```


Generate the *APP_KEY*
```bash
  php artisan key:generate
```

Install Node dependencies

```bash
  npm install
```

To start you will need both Laravel + Vue running


```bash
  php artisan serve
```
    
```bash
  npm run dev
```

Now on your browser you could simply visit http://localhost:8000 or use something like Postman to access the API endpoints.


&nbsp; 

# Enpoints

##### [🔗](https://www.postman.com/invites-app/workspace/invites-app/collection/28786356-6ef12979-cb89-469e-b32f-2275bb04ac9c) Postman Collection

#### Get all affiliates
```
  GET /api/v1/affiliates
```

#### Get specific Affiliate by Id

```
  GET /api/v1/affiliates/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of affiliate |


#### Get specific Affiliate by Id

```
  GET /api/v1/affiliates/getByDistance
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `from`      | `string` | **Required**. City Name |
| `km`      | `number` | **Required**. Distance interval in KM |


&nbsp; 


## Running Tests

To run tests, run the following command

```bash
  php artisan test
```


![Test Results](https://raw.githubusercontent.com/fatimaestrada/invites-app/master/readme/test.png)


&nbsp; 


## Deployment

To deploy this I used [vercel](https://vercel.com/) that one the setup files are added, allows me to just run 

```bash
  vercel .
```

&nbsp; 

&nbsp; 


## Possible improvments / Upcoming features

- Add external API like Geonames or Positionstrack to get city geolocation.

- Replace coordinates strings `latitude, longitude `  with map component.

- Include GitHub actions for unit test feedback.



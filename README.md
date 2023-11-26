# SD-REST-APIs

### Introduction

This plugin is a representation of a WordPress REST APIs. One custom post type having few custom fields can be accessed and added using REST APIs


### Prerequisites

- WordPress installtion on the server or in your system

### Installation

> **Uploading within WordPress Dashboard**

```
    1. Download the zip of this repository.
    2. Navigate to ‘Add New’ within the plugins dashboard.
    3. Navigate to ‘Upload’ area.
    4. Select ‘zip of plugin files’ from your computer.
    5. Click ‘Install Now’.
    6. Activate the plugin within the Plugin dashboard.
```

### Objectives

1) Custom post type "Events" has been created to execute these APIs
2) Rest APIs which will perform below actions

   - Authenticate users by JWT token
   - Get all the events
   - Get single event by event ID
   - Insert new event
   - Update event by event ID
   - Delete event by event ID



### How does this plugin works?

* Execute these APIs in your code using CURL or AJAX requests
* Execute these APIs using API testing platform such as 'Postman'.

### APIs

1. POST {{wordpress_url}}/wp-json/jwt-auth/v1/token: Get an access token.
 
```
Example: Pass JSON data as below with "POST" request
URL: https://demo.shwetadanej.com/wp-json/jwt-auth/v1/token
    
{
  "username": "demo",
  "password": "demo"
}
```

2. GET {{wordpress_url}}/wp-json/demo/v1/events: Retrieve a list of events.

```
Example: Pass JWT bearer token as authentication with "GET" request
URL: https://demo.shwetadanej.com/wp-json/demo/v1/events
```
    
3. GET {{wordpress_url}}/wp-json/demo/v1/events/{id}: Retrieve details of a specific event.
```
Example: Pass JWT bearer token as authentication and event ID with "GET" request
URL: https://demo.shwetadanej.com/wp-json/demo/v1/events/55
```

4. POST {{wordpress_url}}/wp-json/demo/v1/events: Create a new event.
```
Example: Pass JWT bearer token as authentication and JSON data as below given with "POST" request
URL: https://demo.shwetadanej.com/wp-json/demo/v1/events

{
  "title": "New Event",
  "description": "A description for the new event",
  "date" : "2024-1-1",
  "location" : "Surat"
}
```

5. PUT {{wordpress_url}}/wp-json/demo/v1/events/{id}: Update an existing event.
```
Example: Pass JWT bearer token as authentication, event ID and JSON data as below given with "PUT" request
URL: https://demo.shwetadanej.com/wp-json/demo/v1/events/55

{
  "title": "New Event",
  "description": "A description for the new event",
  "date" : "2024-1-1",
  "location" : "Surat"
}
```

6. DELETE {{wordpress_url}}/wp-json/demo/v1/events/{id}: Delete an event.
```
Example: Pass JWT bearer token as authentication and event ID with "DELETE" request
URL: https://demo.shwetadanej.com/wp-json/demo/v1/events/55
```

### Credits

[JWT Authentication for WP REST API](https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api) plugin has been used to get JWT access token.

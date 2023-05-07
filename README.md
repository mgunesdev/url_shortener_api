# Url Shortener API

- The project is a URL shortening service that works with the REST API.

### Features

- Users can register to the service with their email and password.
- Users can create and edit their own links.
- If URL extension (slug) is not specified, random is determined.
- When you enter the created page, you will be redirected to the link.
- IP record of each visit is kept.
- Every day at 10:00 am according to the user's local time
  information to users how many unique visits to their links
  sent by mail. [JobDailyReminderVisits](app%2FConsole%2FCommands%2FJobDailyReminderVisits.php)


### Requirements

- PHP version: 8.1

- Laravel version : 9.x

- Database : mysql

- Cache: redis

### Endpoints

- In addition, for use the system, register and then login endpoints must be called.

```
   POST  -   {{host}}/api/auth/register/
   POST  -  {{host}}/api/auth/login/
```

- Url api endpoints:

```
   POST    - {{host}}/api/url/create/
   GET     - {{host}}/ api/url/{id}/
   POST    - {{host}}/api/url/{id}/
   DELETE  - {{host}}/api/url/{id}/
```

Download [Postman Collection](docs/URL_Shortener_API.postman_collection.json).
and [Postman Environment](docs/LOCAL.postman_environment.json).

### Quick Start

1. Download the latest docker.


2. Run the script from the root directory of the Laravel project

```bash
curl -s "https://gist.githubusercontent.com/LaurenceRawlings/3b4f801cafb2e683f45a3b573dad868d/raw/15c952586e75d514b909aec6a6e47088563c6612/sail-setup" | bash
```

- This script can be found at the bottom of the page

3. Configure a bash alias

```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

4. Add a .env file
   See below for default Sail values

```bash
cp .env.example .env
```

5. Start Sail

```bash
sail up -d
```






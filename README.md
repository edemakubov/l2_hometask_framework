## Building and running your application



Your application will be available at http://localhost:4321.

When you're ready, start your application by running:
```bash
docker compose up --build
```


Create New EndPoint: 

1. Create a Controller file in the `app/Http/Controllers` directory.
2. Create a method in the controller file.
3. Register new route in the `app/routes.php` file.

Example: 
 
```php  
[
     '/#path#' => [
        'controller' => '#ControllerName#',
        'action' => '#controllerMethod#'
    ],
]
```

## Run code analysis

You can run the code analysis tools on your codebase by running:

1. PHPStan
```bash
docker exec l2_hometask_framework-server-1 composer phpstan
```

2. Psalm
```bash
docker exec l2_hometask_framework-server-1 composer psalm
```

3. PHP_CodeSniffer
```bash
docker exec l2_hometask_framework-server-1 composer php-code-sniffer
```


4. Tests
```bash
docker exec l2_hometask_framework-server-1 composer test
```



## Templating Engine

- **HTML Responses**: Use the `TemplateEngine` class to render HTML templates.
- **JSON Responses**: Use the `json_encode` function to return JSON responses.

## Security Measures

- Output is escaped using `htmlspecialchars` to prevent XSS attacks.
- Variables are extracted with `EXTR_SKIP` to avoid overwriting existing variables.

## Usage

### HTML Response

```php
$content = $templateEngine->render('template_name', ['variable' => 'value']);
$response->setContent($content);
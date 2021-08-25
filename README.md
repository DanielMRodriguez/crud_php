# CRUD con PHP y AJAX

Es un CRUD usando PHP apoyado con un framework tiny llamado [slim](https://www.slimframework.com/docs/v4/) solamente para manejar las rutas.

El backend esta hecho con PHP, me apoye en un framework tiny únicamente para manejar las rutas, además hice el modelo y la lógica con PHP vanilla, con una clase conexión que utiliza PDO y una clase usuario (que es el único objeto) que hereda de conexión para hacer los queries.

El frontend esta hecho con bootstrap y jquery, la tabla con el plugin de [DataTables](https://datatables.net/), las peticiones ajax estan hechas con fetch.


## Instalación

Para instalar el proyecto solo hace falta clonar el repositorio

```bash
git clone https://github.com/DanielMRodriguez/crud_php.git
```

Después ir a la carpeta api desde la termial

```bash
cd crud_php && cd api
```

Una vez aquí hay que instalar las dependencias de [composer](https://getcomposer.org/)

```bash
composer install
```

Y para terminar solamente hace falta que definas las variables de entorno, 

```env
DB_USER=root
DB_PASSWORD=
DB_HOST=127.0.0.1
DB_NAME=database
BASE_PATH=/crud/api
```

## Usabilidad
Una vez instalado solamente tienes que crear una base de datos y una tabla de nombre users con los campos, name, last_name, phone, email, created_at, deleted, updated_at, y listo ya puedes usar el crud.


## License
[MIT](https://choosealicense.com/licenses/mit/)

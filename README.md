# Prueba PHP avanzado 2021
## _NRS Group Federico Miguez_

[![N|Solid](https://www.nrs-group.com/assets/img/logo.png)](https://www.nrs-group.com/)

Prueba Técnica para formar parte del equipo de trabajo.

#### Prueba Tecnica
Desarrollar una aplicación PHP para gestionar las reservas de un teatro, teniendo en cuenta que:
- Es imprescindible el uso de Laravel como framework MVC.
- Es imprescindible el uso de GIT como repositorio de código.
- Es imprescindible el uso de bootstrap.
- Los datos se deben almacenar en una base de datos MySQL
- Se debe guardar el log en un fichero de texto cada vez que se realiza una reserva.
- Debemos guardar datos de los usuarios y reservas (no significa que sean obligatoriamente 2 tablas ni que los campos tengan que ser los mismos)
- usaurios 
- - Nombre
- - Apellido
- Reservas
- - Fecha
- - Número de personas
- - Butacas
- - - Fila(de 1 a 5)
- - - Columna(de 1 a 10)
- En la misma reserva puede haber varias butacas. Por ejemplo, el usuario 1 puede reservar la butaca 2-3, la butaca 2-4 y la butaca 4-6.
- Para cada butaca reservada se debe seleccionar a qué fila y columna pertenece.
- Se debe comprobar la disponibilidad.

#### Se valorará
- CRUD completo de reservas y usuarios.
- La organización del código.
- Comprobación de errores.

#### Opcional
- Montar todo en un sistema docker para que cuando se descargue el proyecto hacer docker-compose up y se levante la app php y la base de datos y todo funcione.



#### Forma de Entrega
- Se debe subir a un repositorio de GitHub haciendo todos los commits que se harían si fuese un proyecto normal, separando bien las funcionalidades implementadas.

# Instalacion
- ` composer install`
- ` npm install `
- crear una base de datos
- reemplazar los datos de conexion a DB en el archivo .env 
- `php artisan migrate`
- `php artisan key:generate`

# Correr proyecto
- `php artisan serve`
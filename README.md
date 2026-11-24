# Sistema web del parque estatal "El Texcal"

## Definición del problema
Debido a la pandemia, el parque dejó de ser visitado, y esto provocó que el funcionamiento de las instalaciones del parque se vieran afectadas, ocasionando que las autoridades de los Bienes Comunales de Tejalpa se hayan percatado de que no cuentan con el suficiente alcance de difusión del parque como para mantener informados a los visitantes con información fiable y actualizado del estado y características con las que cuenta el parque.
En cuanto a la parte administrativa, el manejo de la información y registros se llevan a cabo de manera manual, lo que genera mucha papelería causando que sea difíci la gestión de información y que sea propensa a pérdidas ante algún robo o desastre natural de forma permanente sin manera de recuperarla de algún respaldo.

## Objetivos
#### General

- Desarrollar un sistema web que permita la difusión de la publicidad así como la administración de mantenimientos, locales, tarifas y empleados del parque estatal “El Texcal”.

#### Específicos

- Investigar el estado actual del parque y de la empresa para tener en cuenta las necesidades principales que requieren los usuarios visitantes y trabajadores.
- Definir los requisitos del sistema que permitan mostrar información actualizada del parque al igual que el seguimiento de las tareas del personal.
- Elaborar los diseños de interfaz que cuenten con elementos que permitan a los usuarios llevar una navegación e interacción coherente con el sistema de
administración del parque “El Texcal” y apoyen a la difusión de su información.
- Seleccionar las tecnologías adecuadas con el fin de facilitar la implementación del sistema de administración del parque “El Texcal”.
- Implementar y probar los módulos del sistema de administración del parque “El Texcal” para verificar el correcto funcionamiento e integración de los
módulos del sistema.

## Justificación
Dado que los sitios web acerca del parque no brindan información actual, se pretende llevar a cabo el desarrollo de un sistema web que permita al público conocer los servicios, tarifas e instalaciones actuales con las que cuenta el parque estatal “El Texcal”, ayudando así a tener una mejor difusión del lugar de forma virtual, además de que también será de apoyo para que los encargados y el personal del parque lleven un mejor seguimiento de las tareas de mantenimiento, gestión del personal y administración de los recursos visuales que estarán disponibles para los usuarios del sistema.

## Alcances
- El sistema web permitirá administrar fácilmente la publicidad de los servicios que ofrece el parque el Texcal.
- El sistema web permitirá administrar el proceso de realización de cada uno de los mantenimientos del parque el Texcal.
- El sistema web permitirá llevar a cabo la gestión de registros del personal al igual que de los locales y los productos con los que cuenta cada uno.
- El sistema web permitirá interactuar con los visitantes registrados respecto a sus comentarios y solicitudes de visitas.
- El sistema web permitirá realizar reportes del sistema al igual que la recuperación de cuentas.

## Limitaciones
- El sistema no podrá efectuar las funciones si no se está previamente registrado con un correo electrónico existente.
- El sistema solo podrá funcionar de manera adecuada a través de las últimas versiones de los navegadores web (Chrome, Opera y Brave).
- El sistema requiere de conexión a internet para el envío de notificaciones y el uso de los estilos en Bootstrap.
- El sistema requiere de una cuenta de correo electrónico activa para poder realizar sus funciones adecuadamente.

## Tecnologias utilizadas
<p align="left">
  <a href="https://www.w3.org/html/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/html5/html5-original-wordmark.svg" alt="html5" width="40" height="40"/> </a>
  <a href="https://www.w3schools.com/css/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/css3/css3-original-wordmark.svg" alt="css3" width="40" height="40"/> </a> 
  <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/javascript/javascript-original.svg" alt="javascript" width="40" height="40"/> </a> 
  <a href="https://www.mysql.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/mysql/mysql-original-wordmark.svg" alt="mysql" width="40" height="40"/> </a> 
    <a href="https://www.php.net" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/> </a>
  <a href="https://getbootstrap.com" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/bootstrap/bootstrap-plain-wordmark.svg" alt="bootstrap" width="40" height="40"/> </a>
</p>

## Funcionamiento
- FN.1. Registro de usuarios tipo visitante: En caso de no tener una cuenta, existe una opción para registrarse como visitante, para ello, se solicita al usuario el nombre, apellido, teléfono, correo y contraseña.

![Captura de pantalla 2023-06-10 192005](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/db1e2ac7-aca6-4427-b4a5-af6df0acd535)
> Figura 1. Prueba de registro de un visitante

![Captura de pantalla 2023-06-10 192018](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/328b80d5-0d52-450c-89c8-41e8d63a0f76)
> Figura 2. Mensaje de registro exitoso.

![Captura de pantalla 2023-06-10 192221](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/6977800a-3010-4f10-bfc1-2932a5b61d83)
> Figura 3. Correo envíado a la bandeja del usuario.

- FN.2. Inicio de sesión de usuarios: Cuando se requiera ingresar al sistema se solicita llenar el registro correspondiente que se basará en su correo y contraseña.

![Captura de pantalla 2023-06-10 192422](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/5034598b-10c0-450c-99e9-769f1d26c32b)
> Figura 4. Ingreso de datos para el inicio de sesión.

![Captura de pantalla 2023-06-10 192536](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/f9c66277-9737-4266-86c5-4b70bb11c400)
> Figura 5. Menú principal del administrador.

- FN.3. Recuperación de usuario y contraseña: El sistema permite a los usuarios recuperar su contraseña en caso de que la hayan olvidado. Se solicita el correo electrónico con el que se haya registrado la cuenta y se enviará un link con un formulario que permitirá crear una nueva contraseña. Una vez actualizada la contraseña se enviará al correo un mensaje con la nueva contraseña.

![Captura de pantalla 2023-06-10 192713](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/1854d240-6cea-4a1a-b31d-585a4cde45f0)
> Figura 6. Llenar el formulario.

![Captura de pantalla 2023-06-10 192757](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/15befe39-c42f-4714-a239-af50c0a23ff7)
> Figura 7. Correo enviado al usuario.

![Captura de pantalla 2023-06-10 193033](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/f98c3a5f-005e-4619-a1cd-413c0d01a010)
> Figura 8. Formulario para el cambio de contraseña.

- FN.4. Gestión de empleados: El sistema permite al administrador agregar, eliminar, consultar y actualizar la información de los empleados.

![Captura de pantalla 2023-06-10 193146](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/20d9ad7b-e889-4676-952b-4829c237dfa9)
> Figura 9. Interfaz para gestionar la información de los empleados.

![Captura de pantalla 2023-06-10 193413](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/324dc4d3-134e-41e8-995c-88dcff8ce805)
> Figura 10. Formulario para un nuevo empleado.

![Captura de pantalla 2023-06-10 193428](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/fc4f0b0d-331e-4d1f-9efe-612ac812d10f)
> Figura 11. Correo que recibe el usuario una vez que ha sido registrado.

![Captura de pantalla 2023-06-10 193447](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/5e5dddb8-933e-4f96-bd34-ccd12d740c60)
> Figura 12. Eliminación de un empleado.

- FN.5. Publicación de imágenes y videos: Se podrá realizar una publicación de alguna imagen o video con descripción para la sección principal del sistema web, las cuales son gestionadas por el administrador.

![Captura de pantalla 2023-06-10 193651](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/bf53961c-5599-4ca6-8a8f-a79b4a2d7777)
> Figura 13. Formulario para una nueva publicación.

![Captura de pantalla 2023-06-10 193706](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/a9cb74ea-b4ed-4653-8ca3-49ee7275c287)
> Figura 14. Interfaz para gestionar las publicaciones.

- FN.6. Gestión de comentarios: El sistema permite al usuario de tipo visitante agregar, eliminar, consultar o modificar sus comentarios. Y el administrador podrá realizar eliminaciones de los comentarios que considere inapropiados.

![Captura de pantalla 2023-06-10 193938](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/c216bece-0b4a-44ca-b624-6d480c1a64bd)
> Figura 15. Panel para gestionar los comentarios del visitante.

![Captura de pantalla 2023-06-10 194105](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/3a649205-a7d1-41a9-a445-0302bb2f8bb3)
> Figura 15. Comentario mostrado en la sección del servicio.

- FN.7. Gestión de boletos: El sistema permite al administador realizar el registro, modificación, consulta y eliminación de las distintas tarifas de los servicios con los que dispone el parque para los visitantes.

![Captura de pantalla 2023-06-10 194423](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/8e668111-37c1-42a0-9abc-d52f0f6a6ea3)
> Figura 16. Panel para gestionar los boletos.

![Captura de pantalla 2023-06-10 194356](https://github.com/GiovannaGarcia6/SistemaWeb-ParqueTexcal/assets/121702527/9e7a23a0-99e1-407f-8f51-52c1546e7ef6)
> Figura 17. Boletos existentes en el servicio del balneario.

- FN.8. Gestión del catálogo de productos:El usuario de tipo vendedor puede realizar el registro, actualización, consulta y eliminación de sus productos y visualizarlos dentro de su apartado en la sección de productos.

- FN.9. Control de Mantenimiento: El administrador puede agregar, eliminar, consultar y modificar actividades para el mantenimiento del parque. Para consultar las actividades se despliega una tabla con los registros en los que cada uno tendrá la opción de eliminar o modificar.
El usuario de mantenimiento tendrá la opción de visualizar las actividades que se le han asignado y cambiar el estatus de estas.

- FN.10. Control de visitas guiadas: El visitante puede acceder a su cuenta en el que tendrá la opción de solicitar una visita a través de un formulario.
El guía puede aceptar o rechazar las solicitudes que hayan realizado los visitantes, además consultará las visitas guiadas que tenga.
Cuando las visitas son aceptadas, rechazadas o canceladas se notifica al visitante con un correo.

- FN.11. Chat: El guía y el visitante tienen un chat que se genera una vez que la visita guiada ha sido aceptada, donde se registran mensajes y que se eliminan una vez que la visita guiada haya sido marcada como finalizada, rechazada o en su defecto cancelada.

- FN.12. Archivero: El administrador puede agregar, eliminar, consultar y actualizar carpetas, en donde cada carpeta tendrá la opción de subir
archivos en formato PDF.

- FN.13. Gestión de eventos: El administrador puede agregar, eliminar, consultar y actualizar eventos, los cuales están a disposición de todo aquel
usuario que visite la página del parque.

- FN.14. Reportes: El administrador podrá generar dos tipos de reportes en formato PDF: 

  - El primer reporte corresponde al de las puntuaciones de las distintas zonas y servicios del parque, en el que se va a mostrar dos opciones, la primera opción es una gráfica con el servicio seleccionado, en donde se incluyen los comentarios buenos y malos que tenga dicha opción; y la segunda opción es una
gráfica con todos los servicios mostrando cual es el mejor de todos y la lista de comentarios buenos comentarios que hace que destaque de los demás servicios.

  - El segundo reporte es de las actividades de mantenimiento que incluye una gráfica mostrando el estado de las actividades, así como la lista de actividades separadas por cada estatus y además un conteo de quién es el empleado que ha tenido un mejor desempeño en la conclusión de sus actividades.

Por otra parte, el guía podrá realizar un reporte de sus visitas guiadas, en el que tendrá la opción de seleccionar un rango de fechas para obtener el total de visitas y la información de todas las visitas realizadas.

- FN.15. Respaldo y recuperación de la base de datos: El sistema permite al usuario de tipo administrador generar y guardar el respaldo de la base de datos en formato sql desde el sistema web, al igual que permitirá restaurarla seleccionando el script desde el navegador de archivos.

- FN.16. Gestión de locales: El sistema permite el registro, modificación, consulta y eliminación de los locales que registre un usuario de rol vendedor.

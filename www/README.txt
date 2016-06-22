==========
DEVELOPMENT ENVIRONMENT:
 - Windows XP.
 - XAMPP 1.8 for Windows XP
 
Notes:
 [+] .htaccess must be enabled.

==========
DB SCHEMA: `db_booking.sql` in root folder.


==========
SOURCE CODE:
 - Library: Zend Framework 1.12
 - Error handling: using ZF's default error handling (see: application/controllers/ErrorController.php).
 - Logging: using ZF's simple file log (see: appliction/controllers/WebAPIController.php)
   Notes: log file located at `data/access.log`. So, make sure this file, or folder is writeable.
 - App's logic: all was implemented in appliction/controllers/WebAPIController.php.
 - Change database connection: application/configs/application.php (find resources.db.params...)


==========
DEMO:
 - WebAPI link: http://localhost/interview-round1/public_html/web-api/booking (use GET method to access).
/** 
 * @param int|string $building_id Building id
 * @param string $building_name Building name
 * @param string $building_address Building adress
 * @param string $room_number Room number
 * @return string JSON
 */


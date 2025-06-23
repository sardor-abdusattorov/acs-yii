# Features
- Role Based Access Control
- Responsive Design
- Modal Form
- Bulk Action
- Light/Dark Mode
- Toast Notification
- Rich Feature Datatable Serverside
- Tooltip
- 
# Requirements
- Php 8.2
- Composer
- Mysql
- Apache
- 
# Installation
``` bash
clone this repository
cd project
composer install
composer update

SETTING UP DB CONNECTION AND TOKENS IN MAIN-LOCAL.PHP
yii migrate --migrationPath=@yii/rbac/migrations/
yii migrate --migrationPath=@yii/i18n/migrations/
yii migrate
```
## Login With
### superadmin
``` bash
login : admin
password : 123456
```
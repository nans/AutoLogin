# AutoLogin - Magento 2 extension 
Magento 2 - Autologin for customer (frontend) and user (admin panel) 

Admin can activate autologin for customer and admin.  

For good work recomended in Settings -> Advanced - Admin - Security  
Set:  
Admin Account Sharing set Yes  
Add Secret Key to URLs set No 

Note: if activated autologin for admin, you cant's sign out.  

# Supported  
Magento 2.1.x - 2.3.x  
Magento 2.0 - correct work is not guaranteed  
[PHP 5.6](https://github.com/nans/AutoLogin/tree/php-5.6)  
PHP 7.0 and higher  

# Installation Instruction  
* Copy the content of the repo to the Magento 2: app/code/Nans/AutoLogin  
* Run command: php bin/magento setup:upgrade  
* Run command: php bin/magento cache:clean

# Support  
If you encounter any problems or bugs, please open an [issue](https://github.com/nans/AutoLogin/issues) on GitHub.

## Command for disable autologin on frontend and backend  
For frontend: php bin/magento autologin:disable f  
For backend: php bin/magento autologin:disable b  
For backend and frontend: php bin/magento autologin:disable all 

After command execute, for clean cache run command: php bin/magento cache:clean
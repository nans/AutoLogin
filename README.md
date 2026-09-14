# AutoLogin - Magento 2 extension 
Magento 2 - Autologin for customers (frontend) and admins (backend)  
An admin can activate autologin for customers and admins.  
![Sample](https://github.com/nans/devdocs/blob/master/AutoLogin/Settings.png "Settings")    

For proper operation, it is recommended to set the following options in "Settings -> Advanced - Admin - Security":  
"Yes" for "Admin Account Sharing"   
"No" for "Add Secret Key to URLs"  

Note: If autologin is enabled for an admin, you cannot log out.  

# Supported  
Magento 2.1.x and higher.   
Requires PHP 8.0 or higher.  

# Installation Instructions  
## Upload Magento extension via ZIP/Archive
* Copy the contents of the repository to: app/code/Nans/AutoLogin  
* Run the following command: php bin/magento module:enable Nans_AutoLogin  
* Run the following command: php bin/magento setup:upgrade  
* Run the following command: php bin/magento cache:clean  
##  Install Magento 2 extension via Composer
* Run the following command: composer require nans/magento2-autologin
* Run the following command: php bin/magento module:enable Nans_AutoLogin
* Run the following command: php bin/magento setup:upgrade
* Run the following command: php bin/magento cache:clean  


# Support  
If you encounter any problems or bugs, please open an [issue](https://github.com/nans/AutoLogin/issues) on GitHub.

## Commands for disabling autologin on the frontend and backend  
For frontend: php bin/magento autologin:disable f  
For backend: php bin/magento autologin:disable b  
For backend and frontend: php bin/magento autologin:disable all 

After executing the command, clear the cache by running: php bin/magento cache:clean

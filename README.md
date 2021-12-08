# Подготовка
Убедитесь, что установлены:
- node 15 версии
- python 3.8.10
- настроенный сервер nextcloud
- развернутая база sql

Разрешаем www-data подключаться к пользователю и запускать процессы. Открываем:

    sudo visudo -f /etc/sudoers.d/custom
    
 Добавляем строку:
  
    www-data ALL=(user:user) NOPASSWD:ALL  
     
 Далее добавляем пользователя в группу www-data:
 
    sudo usermod -aG www-data user
    
 Разрешаем изменения в папке приложений:
 
     cd nextcloud
     chmod -R g+w apps
     
# Установка 

  Клонируем приложение-словарь в папку customprop_dict: 
      
      cd nextcloud/apps
      git clone https://github.com/antonioiksi/nextcloud-customprop_dict.git customprop_dict
      
  Клонируем основное приложение ветки feature-filestable-and-select-cp в папку customproperties: 
  
      cd nextcloud/apps
      git clone https://github.com/antonioiksi/nextcloud-customproperties.git -b feature-filestable-and-select-cp customproperties
      
   Компилируем приложение
   
      cd nextcloud/apps/customproperties
      ./build.sh
  


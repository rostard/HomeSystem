sudo cp web/* /var/www/html
sudo cp auto_light_time.txt /var/www/html
sudo cp on_event.py /var/www/html

cd modbus_io && cmake .
make
sudo cp modbus_io /var/www/html
cd /var/www/html/ && sudo echo 0 > lsm

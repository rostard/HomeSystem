sudo cp web/* /var/www/html
cd modbus_io && cmake .
make
sudo cp modbus_io /var/www/html
sudo echo 0 > /var/www/html/lsm

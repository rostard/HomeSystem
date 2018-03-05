cmake_minimum_required(VERSION 2.8)
project(modbus_io)

set(CMAKE_CXX_STANDART 14)

set(SOURCE_FILES main.cpp)
add_executable(modbus_io ${SOURCE_FILES})
target_link_libraries(${PROJECT_NAME} -L/usr/local/lib -lmodbus)
include_directories(/usr/local/include/modbus)

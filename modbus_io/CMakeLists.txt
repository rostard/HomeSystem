cmake_minimum_required(VERSION 3.9)
project(modbus_io)

set(CMAKE_CXX_STANDART 14)

set(SOURCE_FILES main.cpp)
add_executable(modbus_io ${SOURCE_FILES})
target_link_libraries(${PROJECT_NAME} -L/usr/local/lib -lmodbus -pthread)
include_directories(/usr/local/include/modbus)
SET(CMAKE_CXX_FLAGS "${CMAKE_CXX_FLAGS} -std=gnu++0x")

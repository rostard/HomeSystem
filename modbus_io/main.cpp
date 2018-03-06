#include <stdio.h>
#include <stdlib.h>
#include <iostream>
#include <modbus.h>
#include <errno.h>
#include <unistd.h>
#include <string.h>
#include <semaphore.h>
#include <fstream>
#include <fcntl.h>

modbus_t* mc;


#define LAST_SEM_FILE "/var/www/html/lsm"


int main(int argc, char* argv[]){
	int adress = 1;
	int reg = -1;
	uint16_t val = 1;
	int num = 1;

	int task = 0; // if we want to read registers(-1) or write(1)

	if(argc == 1){
		//check parameters
		std::cout<<"print -h for help"<<std::endl;
		return 0;
	}
	if(strcmp(argv[1], "set") == 0)	task = 1;
	else if(strcmp(argv[1], "get") == 0) task = -1;
	else {
		printf("choose set or get");
		return 0;
	}

	// check arguments
	int rez;
	while ((rez = getopt(argc, argv, "ha:r:v:n:")) != -1) {
		switch (rez) {
		case 'h':
			printf("use a <value> for adress\n"
                           "use r <value> for register\n"
                           "use v <value> for value");
			return 0;
			break;
		case 'a':
			adress = atoi(optarg);
			break;
		case 'r':
			reg = atoi(optarg);
			break;
		case 'v':
			val = atoi(optarg);
			break;
		case 'n':
			num = atoi(optarg);
			break;
		};
	};


	printf("address = %i\n",adress);
	printf("register = %i\n",reg);
	printf("value = %i\n",val);

// -------------------------------------------------------------------------
    int lastSemaphoreName;
    std::ifstream ifstream(LAST_SEM_FILE);
    ifstream>>lastSemaphoreName;
    ifstream.close();
    std::ofstream ofstream(LAST_SEM_FILE);
    ofstream<<lastSemaphoreName + 1;
    ofstream.close();

    //If there are another processes - wait
    if(lastSemaphoreName != 0){
        sem_t* prevSemaphore = sem_open(("/modbus_queue" + std::to_string(lastSemaphoreName)).c_str(), O_CREAT, S_IRUSR | S_IWUSR, 0);
        sem_wait(prevSemaphore);
        sem_close(prevSemaphore);
    }
    //Don't len any process go further
    sem_t* nextSemaphor = sem_open(("/modbus_queue" + std::to_string(lastSemaphoreName + 1)).c_str(), O_CREAT, S_IRUSR | S_IWUSR, 0);
//----------------------------------------------------------------------------
	//create modbus connection at adress "adress"
	mc=modbus_new_rtu("/dev/ttyUSB0", 115200, 'N', 8, 1);
	modbus_set_slave(mc, adress);
	if(modbus_connect(mc)==-1){
		fprintf(stderr, "Connection failed: %s\n", modbus_strerror(errno));
		return 1;
	}
	if(task == 1){
		//write to registister "reg" value "val"
		modbus_write_register(mc, reg, val);
		int ret;
		uint16_t buf[1];
		if(ret=modbus_read_registers(mc, reg, 1, buf) == -1){
			fprintf(stderr, "Read_registers failed: %s\n", modbus_strerror(errno));
			modbus_free(mc);
			return 1;
		}
		//check if value was wriiten
		if(buf[0] != val){
			fprintf(stderr, "Value %i wasn't written", val);
			modbus_free(mc);
			return 1;
		}
	}
	else if(task == -1){
		//read "num" registers from "reg"
		int ret;
		uint16_t buf[64];
		if((ret=modbus_read_registers(mc, reg, num, buf))==-1){
			fprintf(stderr, "Read_registers failed: %s\n", modbus_strerror(errno));
			modbus_free(mc);
			return 1;
		}
		//print all read registers
		for(int i = 0; i<num; i++)
			printf("%i\n", buf[i]);
	}
	modbus_free(mc);
//----------------------------------------------------------------------------
    int currentSemaphoreLastName;
    std::ifstream closing_ifstream(LAST_SEM_FILE);
    closing_ifstream>>currentSemaphoreLastName;
    closing_ifstream.close();
    //If there are no processes behind you in queue, next process shouldn't create semaphore
    if(currentSemaphoreLastName == lastSemaphoreName + 1){
        std::ofstream ofstream(LAST_SEM_FILE);
        ofstream<<0;
        ofstream.close();
    }
    else{
        //Else let next process do its work
        sem_post(nextSemaphor);
    }

	return 0;
}

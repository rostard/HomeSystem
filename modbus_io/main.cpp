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
#include <sys/types.h>
#include <sys/file.h>

modbus_t* mc;


#define LAST_SEM_FILE "/var/www/html/lsm"


void error_exit(const std::string& message, sem_t* nextSem, std::ostream& log){
	log<<message<<std::endl;
	std::ofstream ofstream(LAST_SEM_FILE);
        ofstream<<0;
        ofstream.close();
	sem_post(nextSem);
}


int main(int argc, char* argv[]){
	std::string logFileName("/tmp/modbus_io.log" + std::to_string(getpid()));
	std::ofstream log(logFileName, std::ios_base::app);
	FILE* f = fopen(LAST_SEM_FILE, "r");
	int result = flock(fileno(f), LOCK_EX);
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

//----------------------------------------------------------------------------
	//create modbus connection at adress "adress"
	mc=modbus_new_rtu("/dev/ttyUSB0", 115200, 'N', 8, 1);
	modbus_set_slave(mc, adress);
	int numOfTries = 0;
	int mxTries = 5;
	for(numOfTries = 0; numOfTries<mxTries && modbus_connect(mc)==-1; numOfTries++){
	}
	if(numOfTries == mxTries){
		log<<"Connection failed: "<< modbus_strerror(errno)<<std::endl;
		return 1;
	}
	if(task == 1){
		//write to registister "reg" value "val"
		for(numOfTries = 0; numOfTries < mxTries && modbus_write_register(mc, reg, val) == -1; numOfTries++){}
		if(numOfTries == mxTries){
                	log<<"Write failed: "<< modbus_strerror(errno)<<std::endl;
                	return 1;
                }

		int ret;
		uint16_t buf[1];
		for(numOfTries = 0; numOfTries < mxTries && modbus_read_registers(mc, reg, 1, buf) == -1; numOfTries++){}
		if(numOfTries == mxTries){
                        log<<"Read failed: "<< modbus_strerror(errno)<<std::endl;
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
		for(numOfTries = 0; numOfTries < mxTries && modbus_read_registers(mc, reg, num, buf) == -1; numOfTries++){}
                if(numOfTries == mxTries){
                        log<<"Read failed: "<< modbus_strerror(errno)<<std::endl;
                        modbus_free(mc);
                        return 1;
                }
		//print all read registers
		for(int i = 0; i<num; i++)
			printf("%i\n", buf[i]);
	}
	modbus_free(mc);
//----------------------------------------------------------------------------
    log.close();
    return 0;
}

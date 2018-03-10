#!/usr/bin/python3

import sys
import time

light_id = int(sys.argv[1])
light_state = int(sys.argv[2])

work_time = []

config_dir = "/var/www/html/"

with open(config_dir + "auto_light_time.txt", "r") as f:
    work_time = [int(i) for i in f.read().split('-')]
    print(work_time)

print("id:", light_id, "state:", light_state)

#If day don't do anything
cur_time = time.localtime(time.time())
if cur_time.tm_hour < work_time[0] and cur_time.tm_hour >= work_time[1]:
    print("Not in time", cur_time.tm_hour)
    exit(0)

import subprocess
read_output = subprocess.Popen(config_dir + "modbus_io get -a5 -r1 -n1", shell=True, stdout=subprocess.PIPE).stdout
cur_light = int(read_output.readlines()[3].strip())
set_value = 0
if light_state:
    with open("/tmp/last_auto_light"+str(light_id), "r") as f:
        if time.mktime(cur_time) - float(f.read()) < 15:
            print("Too soon")
            exit(0)
    set_value = cur_light | 2**light_id
else:
    set_value = cur_light & ~(2**light_id)
    with open("/tmp/last_auto_light"+str(light_id), "w") as f:
        f.write(str(time.mktime(cur_time)))
print("setvalue:", set_value)
subprocess.Popen(config_dir + "modbus_io set -a5 -r1 -v{}".format(set_value), shell=True, stdout=subprocess.PIPE)

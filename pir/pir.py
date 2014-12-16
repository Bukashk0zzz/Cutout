#!/usr/bin/python

import RPi.GPIO as GPIO
import time

GPIO.setmode(GPIO.BCM)
GPIO_PIR = 7

GPIO.setup(GPIO_PIR,GPIO.IN)

Current_State  = 0
Previous_State = 0

try:
  while GPIO.input(GPIO_PIR)==1:
    Current_State  = 0    

  print "  Waiting for action"

  while True :
   
    Current_State = GPIO.input(GPIO_PIR)
   
    if Current_State==1 and Previous_State==0:
      ts = time.time()
      print "  Motion detected! "
      print ts
      f = open('lastMotion', 'r+')
      ts = str(ts)
      f.write(ts)
      f.close()
      Previous_State=1
    elif Current_State==0 and Previous_State==1:
      #print "  Waiting for action"
      Previous_State=0
      
    time.sleep(0.01)
      
except KeyboardInterrupt:
  print "  Quit" 
  GPIO.cleanup()
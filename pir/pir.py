#!/usr/bin/env python

import RPi.GPIO as GPIO
import time
import sqlite3

conn = sqlite3.connect('pir.db')
cur = conn.cursor()

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
      ts = int(ts)
      print ts
      cur.execute("INSERT INTO pir(time) values (strftime('%s', 'now'))")
      conn.commit()
      Previous_State=1
    elif Current_State==0 and Previous_State==1:
      #print "  Waiting for action"
      Previous_State=0
      
    time.sleep(0.01)
      
except KeyboardInterrupt:
  print "  Quit" 
  GPIO.cleanup()
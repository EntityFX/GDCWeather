#!/usr/bin/python
# Copyright (c) 2015 EntityFX
# Author: EntityFX


import Adafruit_BMP.BMP085 as BMP085
import sched, time, threading, MySQLdb

class BmpPollingTimer(object):
    def __init__(self, seconds):
        self.runTime = seconds
        self.db = MySQLdb.connect(host="localhost", user="root", passwd="biohazard1989", db="GDCWeather", charset="utf8")
        self.sensor = BMP085.BMP085()
        #threading.Thread.__init__(self)

    def run(self):
        self.pollData()
        threading.Timer(self.runTime, self.run).start()

    def pollData(self):
        sensorTemp = self.sensor.read_temperature()
        sensorPressure = self.sensor.read_pressure()
        sensorAltitude = self.sensor.read_altitude()

        cursor = self.db.cursor()
        sql = """INSERT INTO `WeatherPollingData` VALUES (0, %(temp)s, %(pressure)s, %(alt)s, NOW())
            """%{"temp":sensorTemp, "pressure":sensorPressure, "alt":sensorAltitude}
        cursor.execute(sql)
        self.db.commit()	

t = BmpPollingTimer(5)
t.run()


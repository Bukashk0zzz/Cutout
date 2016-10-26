var Service,
    Characteristic,
    request = require('request');

module.exports = function (homebridge) {
    Service = homebridge.hap.Service;
    Characteristic = homebridge.hap.Characteristic;
    homebridge.registerAccessory('homebridge-plugin-cutout', 'Cutout', Cutout);
};

function Cutout(log, config) {
    this.log = log;
    this.url = config["url"];
    this.name = config["name"];
}

Cutout.prototype = {
    identify: function (callback) {
        this.log("Identify requested!");
        callback(); // success
    },

    httpRequest: function (name, url, callback) {
        var that = this;
        that.log('Getting '+name);

        request({
            url: url,
            method: "GET"
        },
        function (error, response, body) {
            if (error) {
                that.log('HTTP function failed: %s', error);
            } else {
                that.log('HTTP function succeeded - %s', body);
            }
            callback(error, response, body)
        })
    },

    getTemperature: function (callback) {
        this.httpRequest('Getting temperature', this.url+'/api.php?data=temperature', function(error, response, body) {
            var info = JSON.parse(body);
            callback(null, Number(info.temperature));
        }.bind(this));
    },

    getHumidity: function (callback) {
        this.httpRequest('Getting humidity', this.url+'/api.php?data=temperature', function(error, response, body) {
            var info = JSON.parse(body);
            callback(null, Number(info.humidity));
        }.bind(this));
    },

    getTemperatureOut: function (callback) {
        this.httpRequest('Getting temperature outside', this.url+'/api.php?data=temperature', function(error, response, body) {
            var info = JSON.parse(body);
            callback(null, Number(info.temperature_o));
        }.bind(this));
    },

    getHumidityOut: function (callback) {
        this.httpRequest('Getting humidity outside', this.url+'/api.php?data=temperature', function(error, response, body) {
            var info = JSON.parse(body);
            callback(null, Number(info.humidity_o));
        }.bind(this));
    },

    getVolume: function (callback) {
        this.httpRequest('Getting volume', this.url+'/api.php?data=volume', function(error, response, body) {
            var info = JSON.parse(body);

            var volumeReal = (Number(info.volume)-75)/0.25;
            callback(null, Number(volumeReal));
        }.bind(this));
    },

    setVolume: function (volume, callback) {
        var volumeReal = (Number(volume)*0.25)+75;

        this.httpRequest('Setting volume', this.url+'/api.php?volume='+volumeReal.toFixed(1), function(error, response, body) {
            callback(null);
        }.bind(this));
    },

    getRadioStatus: function (callback) {
        this.httpRequest('Getting radio status', this.url+'/api.php?data=radio', function(error, response, body) {
            var info = JSON.parse(body);
            callback(null, Boolean(info.radio));
        }.bind(this));
    },

    setRadioStatus: function (on, callback) {
        var that = this,
            id = 3;
        if (on) {
            id = 4;
        }
        this.httpRequest('Setting radio status', this.url+'/api.php?homekit=true&id='+id, function(error, response, body) {
            that.speakerService
                .getCharacteristic(Characteristic.On)
                .getValue()
            ;
            that.radioService
                .getCharacteristic(Characteristic.On)
                .getValue()
            ;

            callback(null);
        }.bind(this));
    },

    getServices: function() {
        if (this.name === 'Outside') {
            this.informationServiceOut = new Service.AccessoryInformation();
            this.informationServiceOut
                .setCharacteristic(Characteristic.Identify, 'Bukashk0zzz')
                .setCharacteristic(Characteristic.Manufacturer, 'Bukashk0zzz')
                .setCharacteristic(Characteristic.Model, 'Kitchen')
                .setCharacteristic(Characteristic.Name, 'Kitchen')
                .setCharacteristic(Characteristic.SerialNumber, '0002');

            this.temperatureServiceOut = new Service.TemperatureSensor('Temperature Outside', 'outside');
            this.temperatureServiceOut
                .getCharacteristic(Characteristic.CurrentTemperature)
                .on('get', this.getTemperatureOut.bind(this));


            this.humidityServiceOut = new Service.HumiditySensor('Humidity Outside', 'outside');
            this.humidityServiceOut
                .getCharacteristic(Characteristic.CurrentRelativeHumidity)
                .on('get', this.getHumidityOut.bind(this));

            return [
                this.informationServiceOut,
                this.temperatureServiceOut,
                this.humidityServiceOut
            ];
        }

        this.informationService = new Service.AccessoryInformation();
        this.informationService
            .setCharacteristic(Characteristic.Identify, 'Bukashk0zzz')
            .setCharacteristic(Characteristic.Manufacturer, 'Bukashk0zzz')
            .setCharacteristic(Characteristic.Model, 'Kitchen')
            .setCharacteristic(Characteristic.Name, 'Kitchen')
            .setCharacteristic(Characteristic.SerialNumber, '0001');

        this.temperatureService = new Service.TemperatureSensor('Temperature', 'inside');
        this.temperatureService
            .getCharacteristic(Characteristic.CurrentTemperature)
            .on('get', this.getTemperature.bind(this));


        this.humidityService = new Service.HumiditySensor('Humidity', 'inside');
        this.humidityService
            .getCharacteristic(Characteristic.CurrentRelativeHumidity)
            .on('get', this.getHumidity.bind(this));



        this.radioService = new Service.Switch('Radio');
        this.radioService
            .getCharacteristic(Characteristic.On)
            .on('get', this.getRadioStatus.bind(this))
            .on('set', this.setRadioStatus.bind(this));


        this.speakerService = new Service.Lightbulb('Speaker');
        this.speakerService
            .getCharacteristic(Characteristic.On)
            .on('get', this.getRadioStatus.bind(this))
            .on('set', this.setRadioStatus.bind(this));

        this.speakerService
            .addCharacteristic(new Characteristic.Brightness())
            .on('get', this.getVolume.bind(this))
            .on('set', this.setVolume.bind(this));

        return [
            this.informationService,
            this.temperatureService,
            this.humidityService,
            this.speakerService,
            this.radioService
        ];
    }
};

/*jslint white:true */
/*global angular */
/*
 * Solution for error message: 'angular' was used before it was defined by JSlint
 *  http://stackoverflow.com/questions/31390428/error-angular-was-used-before-it-was-defined-but-online-editors-able-to-outpu
 *
 */
var app = angular.module("unitRout", []);

app.controller("routeControl", function ($scope, $http) {
	"use strict";
	$scope.userCity= "";
	$scope.userState = "";
	$scope.userCountry = "";
	$scope.apiKey = "Ea9fYFZ1cI4Ywk3cGNRkrlmMePIwv395";
	
	$scope.locationID = "Test";
	
	
	
	$scope.getInfo = function(city,state,country){
		var inputCity = city, inputState = state, inputCountry = country;
		
		$scope.userCity= inputCity;
		$scope.userState = inputState;
		$scope.userCountry = inputCountry;
		$scope.locationURL = "http://dataservice.accuweather.com/locations/v1/cities/search?apikey=" + $scope.apiKey + "&q=" + inputCity.split(' ').join("%20");
		
		$scope.getLocation($scope.locationURL);

	
	};
	
	//Get the json directory for any city that match the user city input
	$scope.getLocation = function(address)
	{	
		$http.get(address)
		.then(
			function (response) {
				$scope.locationID = response.data;
				$scope.locationKey = $scope.getLocationKey();
				$scope.getCurrentCondtion($scope.locationKey);
				$scope.getTwelveHourForecast($scope.locationKey);
				$scope.getFiveDaysForecast($scope.locationKey);
				$scope.getTwentyFourHourHistory($scope.locationKey);
				$scope.getSixHourHistory($scope.locationKey);
				$scope.lo = $scope.locationID.AdministrativeArea.LocalizedName.toUpperCase();
			},
			function () {
				// error handling routine
			});
	};
	
	//Get the location key for the city specified by user
	$scope.getLocationKey = function()
	{
		var a=0,key = "";
		
		while(a<$scope.locationID.length)
		{
			if(String($scope.locationID[a].Country.LocalizedName).toUpperCase() === $scope.userCountry.toUpperCase() && String($scope.locationID[a].AdministrativeArea.LocalizedName).toUpperCase() === $scope.userState.toUpperCase())
			{
				key = $scope.locationID[a].Key;
				break;
			}
			a += 1;
		}
		return key;
	};
	
	//Get the current condition
	$scope.getCurrentCondtion = function (key)
	{
		$scope.conditionURL = "http://dataservice.accuweather.com/currentconditions/v1/" + key + "?apikey=" + $scope.apiKey;
		$http.get($scope.conditionURL)
		.then(
			function (response) {
				$scope.weatherCondition = response.data;
				$scope.currentWeather = $scope.weatherCondition[0].WeatherText;
				$scope.currentLoctime = $scope.weatherCondition[0].LocalObservationDateTime;
				$scope.currentTemp = $scope.weatherCondition[0].Temperature.Metric.Value + $scope.weatherCondition[0].Temperature.Metric.Unit;
				$scope.selectedLoc = $scope.userCity + ", " + $scope.userState + ", " + $scope.userCountry;
			},
			function () {
				// error handling routine
		});	
	};

	//Get 12 Hours of Hourly Forecasts
	$scope.getTwelveHourForecast= function (key)
	{
		$scope.conditionForecastURL = "http://dataservice.accuweather.com/forecasts/v1/hourly/12hour/" + key + "?apikey=" + $scope.apiKey + "&details=true";
		$http.get($scope.conditionForecastURL)
		.then(
			function (response) {
				$scope.twelveForecast = response.data;
				$scope.twelveDateStorage = $scope.getTwelveHourDate()[0];
				$scope.twelveTempStorage = $scope.getTwelveHourDate()[1];
				$scope.twelvePrecipRainStorage = $scope.getTwelveHourDate()[2];
				$scope.twelveSnowStorage = $scope.getTwelveHourDate()[3];
				$scope.twelveIceStorage = $scope.getTwelveHourDate()[4];
				$scope.twelveForecastChart();
			},
			function () {
				// error handling routine
		});	
	};	
	
	$scope.getTwelveHourDate = function()
	{
		var a=0,date=[],temp=[],precipRain=[],snow=[],ice=[];
		
		while(a<$scope.twelveForecast.length)
		{
			date.push($scope.twelveForecast[a].DateTime.substring(11,16));
			temp.push($scope.twelveForecast[a].Temperature.Value);
			precipRain.push($scope.twelveForecast[a].PrecipitationProbability);
			snow.push($scope.twelveForecast[a].SnowProbability);
			ice.push($scope.twelveForecast[a].IceProbability);
			a += 1;
		}
		return [date,temp,precipRain,snow,ice];
	};
	
	$scope.twelveForecastChart = function() {
		Highcharts.chart('myfirstchart', {
		
			title: {
				text: 'Twelve Hour Hourly Weather forecast'
			},

			subtitle: {
				text: 'Temperature & Precipitation Probability of rain, snow and ice'
			},
			xAxis: {
				categories: $scope.twelveDateStorage
			},

			yAxis: [{ //1ST Y-AXIS
				labels: {
					format: '{value}F'
				},
				title: {
					text: 'Temperature(F)'
				}

			}, { //2nd Y-AXIS
				title: {
					text: 'Precipitation Probability'
				},
				min:0,
				max:100,
				tickInterval:10,
				opposite: true
			}],

			series: [{
				type: "column",
				name: 'Temperature(F)',
				data: $scope.twelveTempStorage
					}, {	
				type: "line",
				name: 'Rain Precipitation Probability',
				data: $scope.twelvePrecipRainStorage
					}, {	
				type: "line",
				name: 'Snow Precipitation Probability',
				data: $scope.twelveSnowStorage
					}, {	
				type: "line",
				name: 'Ice  Precipitation Probability',
				data: $scope.twelveIceStorage
					}],
			colors: ['red', 'green', 'black','blue']
		});
	};
	
	$scope.getFiveDaysForecast = function(key)
	{
		$scope.fiveDaysURL = "http://dataservice.accuweather.com/forecasts/v1/daily/5day/" + key + "?apikey=" + $scope.apiKey;
		$http.get($scope.fiveDaysURL)
		.then(
			function (response) {
				$scope.fiveDayForecast = response.data;
				$scope.fiveDayDate = $scope.getFiveDaysDate()[0];
				$scope.fiveDayTime = $scope.getFiveDaysDate()[1];
				$scope.fiveDayTemp = $scope.getFiveDaysDate()[2];
				$scope.fiveDayDay = $scope.getFiveDaysDate()[3];
				$scope.fiveDayNight = $scope.getFiveDaysDate()[4];
			},
			function () {
				// error handling routine
		});		
	};
	
	$scope.getFiveDaysDate = function()
	{
		var x=0,date=[],time=[],temp=[],day=[],night=[];
		while(x<$scope.fiveDayForecast.DailyForecasts.length)
		{
			date.push($scope.fiveDayForecast.DailyForecasts[x].Date.substring(0,9));
			time.push($scope.fiveDayForecast.DailyForecasts[x].Date.substring(11,16));
			temp.push($scope.fiveDayForecast.DailyForecasts[x].Temperature.Minimum.Value + "-" + $scope.fiveDayForecast.DailyForecasts[x].Temperature.Maximum.Value);
			day.push($scope.fiveDayForecast.DailyForecasts[x].Day.IconPhrase);
			night.push($scope.fiveDayForecast.DailyForecasts[x].Night.IconPhrase);
			x += 1;
		}
		return [date,time,temp,day,night];
	};
	
	$scope.getTwentyFourHourHistory = function(key)
	{
		$scope.TwentyFourHourURL = "http://dataservice.accuweather.com/currentconditions/v1/" + key + "/historical/24?apikey=" + $scope.apiKey + "&details=true";
		$http.get($scope.TwentyFourHourURL)
		.then(
			function (response) {
				$scope.TwentyFourHour = response.data;
				$scope.TwentyFourHourDate = $scope.getTwentyFourHourDate()[0];
				$scope.TwentyFourHourTime = $scope.getTwentyFourHourDate()[1];
				$scope.TwentyFourHourMin = $scope.getTwentyFourHourDate()[2];
				$scope.TwentyFourHourMax = $scope.getTwentyFourHourDate()[3];
				$scope.TwentyHourChart();
			},
			function () {
				// error handling routine
		});		
	};
	
	$scope.getTwentyFourHourDate = function()
	{
		var x=0,date=[],time=[],min=[],max=[];
		while(x<$scope.TwentyFourHour.length)
		{
			date.push($scope.TwentyFourHour[x].LocalObservationDateTime.substring(0,9));
			time.push($scope.TwentyFourHour[x].LocalObservationDateTime.substring(11,16));
			min.push($scope.TwentyFourHour[x].TemperatureSummary.Past24HourRange.Minimum.Metric.Value);
			max.push($scope.TwentyFourHour[x].TemperatureSummary.Past24HourRange.Maximum.Metric.Value);
			x += 1;
		}
		return [date,time,min,max];
	};
	$scope.TwentyHourChart = function() {
		Highcharts.chart('mysecondchart', {
		
			title: {
				text: 'Previous 24-hour for ' + $scope.TwentyFourHourDate[0]
			},

			subtitle: {
				text: 'Minimum and Maximum Temperature'
			},
			xAxis: {
				title: {
					text: 'Time'
				},
				categories: $scope.TwentyFourHourTime
			},

			yAxis: { //1ST Y-AXIS
				labels: {
					format: '{value}°C'
				},
				title: {
					text: 'Temperature'
				}

			},

			series: [{
				type: "column",
				name: 'Minimum Temperature(C)',
				data: $scope.TwentyFourHourMin
					},{	
				type: "column",
				name: 'Max Temperature(C)',
				data: $scope.TwentyFourHourMax
					}],
			colors: ['red', 'green']
		});
	};	
	
	$scope.getSixHourHistory = function(key)
	{
		$scope.SixHourHistoryURL = "http://dataservice.accuweather.com/currentconditions/v1/" + key + "/historical?apikey=" + $scope.apiKey + "&details=true";
		$http.get($scope.SixHourHistoryURL)
		.then(
			function (response) {
				$scope.SixHourHistory = response.data;
				$scope.SixHourDate = $scope.getSixHourDate()[0];
				$scope.SixHourTime = $scope.getSixHourDate()[1];
				$scope.SixHourHumid = $scope.getSixHourDate()[2];
				$scope.SixHourWindDirecDeg = $scope.getSixHourDate()[3];
				$scope.SixHourWindDirecLoc = $scope.getSixHourDate()[4];
				$scope.SixHourWindSpeed = $scope.getSixHourDate()[5];
				$scope.SixHourWindChillTemp = $scope.getSixHourDate()[6];
				$scope.SixHourChart();
			},
			function () {
				// error handling routine
		});		
	};	
	
	$scope.getSixHourDate = function()
	{
		var x=0,date=[],time=[],humid=[],windDirecDeg=[],windDirecLoc=[],windSpeed=[],windChillTemp=[];
		while(x<$scope.SixHourHistory.length)
		{
			date.push($scope.SixHourHistory[x].LocalObservationDateTime.substring(0,9));
			time.push($scope.SixHourHistory[x].LocalObservationDateTime.substring(11,16));
			humid.push($scope.SixHourHistory[x].RelativeHumidity);
			windDirecDeg.push($scope.SixHourHistory[x].Wind.Direction.Degrees);
			windDirecLoc.push($scope.SixHourHistory[x].Wind.Direction.English);
			windSpeed.push($scope.SixHourHistory[x].Wind.Speed.Metric.Value);
			windChillTemp.push($scope.SixHourHistory[x].WindChillTemperature.Metric.Value);
			x += 1;
		}
		return [date,time,humid,windDirecDeg,windDirecLoc,windSpeed,windChillTemp];
	};
	$scope.SixHourChart = function() {
		Highcharts.chart('mythirdchart', {
		
			title: {
				text: 'Previous 6-hour for ' + $scope.SixHourDate[0]
			},

			subtitle: {
				text: 'Humidity & Wind direction, speed and chill temperature'
			},
			xAxis: {
				title: {
					text: 'Time'
				},
				categories: $scope.SixHourTime
			},

			yAxis: [{ //1ST Y-AXIS
				labels: {
					format: '{value}°C'
				},
				title: {
					text: 'Temperature'
				}

			}, { //2nd Y-AXIS
				title: {
					text: 'Wind Degrees'
				},
				min:0,
				max:300,
				tickInterval:50,
				opposite: true
			}, { //3rd Y-AXIS
				title: {
					text: 'Wind Speed(km/h)'
				},
				min:0.0,
				max:20.0,
				tickInterval:5,
				opposite: true
			}],

			series: [{
				type: "column",
				name: 'Humid °C',
				data: $scope.SixHourHumid
					},{	
				type: "column",
				name: 'Wind Degree',
				data: $scope.SixHourWindDirecDeg
					},{
				type: "column",
				name: 'Wind Speed km/h',
				data: $scope.SixHourWindSpeed
					},{
				type: "column",
				name: 'Chill Temperature °C',
				data: $scope.SixHourWindChillTemp
					}],
			colors: ['red', 'green','black','blue']
		});
	};	
});
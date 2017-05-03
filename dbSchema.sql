-- --------------------------------------------------- --
-- Views para gráficos Anuais e Mensais                --
-- --------------------------------------------------- --

CREATE OR REPLACE VIEW davisYear AS
SELECT t0.*,t1.windDir FROM (
	SELECT YEAR(davis.dateTime) year,
	       AVG(tempOut) tempOut,
	   	   AVG(hiTemp) hiTemp,
	   	   AVG(lowTemp) lowTemp,
	  	   AVG(outHum) outHum,
	       AVG(dewPt) dewPt,
	       AVG(windSpeed) windSpeed,
	       AVG(bar) bar,
	       AVG(rain) rain,
	       AVG(solarRad) solarRad,
	       AVG(UVIndex) UVIndex
    FROM davis  GROUP BY year) t0 JOIN 
    (
  		SELECT YEAR(davis.dateTime) year,
  		       davis.windDir,
  		       COUNT(windDir) n
   		FROM davis GROUP BY year,windDir ORDER BY n DESC LIMIT 1) t1
 ON t0.year = t1.year;

CREATE OR REPLACE VIEW davisMonth AS
SELECT t0.*,t1.windDir FROM (
	SELECT CONCAT(YEAR(davis.dateTime),'-',MONTH(davis.dateTime)) month,
	       AVG(tempOut) tempOut,
	   	   AVG(hiTemp) hiTemp,
	   	   AVG(lowTemp) lowTemp,
	  	   AVG(outHum) outHum,
	       AVG(dewPt) dewPt,
	       AVG(windSpeed) windSpeed,
	       AVG(bar) bar,
	       AVG(rain) rain,
	       AVG(solarRad) solarRad,
	       AVG(UVIndex) UVIndex
    FROM davis  GROUP BY month) t0 JOIN 
    (
  		SELECT CONCAT(YEAR(davis.dateTime),'-',MONTH(davis.dateTime)) month,
  		       davis.windDir,
  		       COUNT(windDir) n
   		FROM davis GROUP BY month,windDir ORDER BY n DESC LIMIT 1) t1
ON t0.month = t1.month;
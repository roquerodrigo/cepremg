-- --------------------------------------------------- --
-- Views para gráficos Anuais e Mensais                --
-- --------------------------------------------------- --
-- Deem uma olhada no campo de direção do vento,       --
-- ele vai retornar sempre um número (0) por causa do  --
-- seu tipo. Portanto precisa ser feito um ajuste      --
-- para pegar a MODA das direções recebidas.           --
-- Quem resolver, por favor manda uma mensagem         --
-- no grupo.                                           --
------------------------------------------------------ --
CREATE OR REPLACE VIEW davisYear AS
SELECT YEAR(d.dateTime) year,
	   AVG(tempOut) tempOut,
	   AVG(hiTemp) hiTemp,
	   AVG(lowTemp) lowTemp,
	   AVG(outHum) outHum,
	   AVG(dewPt) dewPt,
	   AVG(windSpeed) windSpeed,
	   AVG(windDir) windDir, -- CAMPO QUE VAI DAR PROBLEMA
	   AVG(bar) bar,
	   AVG(rain) rain,
	   AVG(solarRad) solarRad,
	   AVG(UVIndex) UVIndex
 FROM davis d GROUP BY year;

CREATE OR REPLACE VIEW davisMonth AS
SELECT CONCAT(YEAR(d.dateTime),'-',MONTH(d.dateTime)) month,
	   AVG(tempOut) tempOut,
	   AVG(hiTemp) hiTemp,
	   AVG(lowTemp) lowTemp,
	   AVG(outHum) outHum,
	   AVG(dewPt) dewPt,
	   AVG(windSpeed) windSpeed,
	   AVG(windDir) windDir, -- CAMPO QUE VAI DAR PROBLEMA
	   AVG(bar) bar,
	   AVG(rain) rain,
	   AVG(solarRad) solarRad,
	   AVG(UVIndex) UVIndex
 FROM davis d GROUP BY month;
# A tabela foi separada em várias de acordo com os tipos de gráficos para aumentar o desempenho.
# Com isso, os cálculos de média, min, max, etc. não precisam ser refeitos a cada consulta.

# Além disso, a tabela de dados diários é atualizada com os dados da tabela com os dados horários,
# a mensal com dados diários e assim por diante. Isso é feito para diminuir o tempo de processamento
# pelo banco ao eliminar cálculos redundantes.

# Ainda falta adicionar o campo de direção do vento. A imlementação anterior estava causando sérios problemas
# de desempenho

# Gráfico horário

TRUNCATE davis_hourly;

INSERT INTO davis_hourly (
  date_time,
  temp_out,
  hi_temp,
  low_temp,
  out_hum,
  dew_pt,
  wind_speed,
  bar,
  rain,
  solar_rad,
  uv_index
)
  SELECT
    DATE_FORMAT(d0.date_time, "%Y-%m-%d %H:00:00") formated_date_time,
    AVG(d0.temp_out)                               temp_out,
    MAX(d0.hi_temp)                                hi_temp,
    MIN(d0.low_temp)                               low_temp,
    AVG(d0.out_hum)                                out_hum,
    AVG(d0.dew_pt)                                 dew_pt,
    AVG(d0.wind_speed)                             wind_speed,
    AVG(d0.bar)                                    bar,
    SUM(d0.rain)                                   rain,
    AVG(d0.solar_rad)                              solar_rad,
    AVG(d0.uv_index)                               uv_index
  FROM davis d0
  GROUP BY formated_date_time
  HAVING COUNT(formated_date_time) >= 0;

# Gráfico diário

TRUNCATE davis_daily;

INSERT INTO davis_daily (
  date_time,
  temp_out,
  hi_temp,
  low_temp,
  out_hum,
  dew_pt,
  wind_speed,
  bar,
  rain,
  solar_rad,
  uv_index
)
  SELECT
    DATE_FORMAT(d0.date_time, "%Y-%m-%d 00:00:00") formated_date_time,
    AVG(d0.temp_out)                               temp_out,
    MAX(d0.hi_temp)                                hi_temp,
    MIN(d0.low_temp)                               low_temp,
    AVG(d0.out_hum)                                out_hum,
    AVG(d0.dew_pt)                                 dew_pt,
    AVG(d0.wind_speed)                             wind_speed,
    AVG(d0.bar)                                    bar,
    SUM(d0.rain)                                   rain,
    AVG(d0.solar_rad)                              solar_rad,
    AVG(d0.uv_index)                               uv_index
  FROM davis_hourly d0
  GROUP BY formated_date_time
  HAVING COUNT(formated_date_time) >= 0;

# Gráfico mensal

TRUNCATE davis_monthly;

INSERT INTO davis_monthly (
  date_time,
  temp_out,
  hi_temp,
  low_temp,
  out_hum,
  dew_pt,
  wind_speed,
  bar,
  rain,
  solar_rad,
  uv_index
)
  SELECT
    DATE_FORMAT(d0.date_time, "%Y-%m-01 00:00:00") formated_date_time,
    AVG(d0.temp_out)                               temp_out,
    MAX(d0.hi_temp)                                hi_temp,
    MIN(d0.low_temp)                               low_temp,
    AVG(d0.out_hum)                                out_hum,
    AVG(d0.dew_pt)                                 dew_pt,
    AVG(d0.wind_speed)                             wind_speed,
    AVG(d0.bar)                                    bar,
    SUM(d0.rain)                                   rain,
    AVG(d0.solar_rad)                              solar_rad,
    AVG(d0.uv_index)                               uv_index
  FROM davis_daily d0
  GROUP BY formated_date_time
  HAVING COUNT(formated_date_time) >= 0;

# Gráfico anual

TRUNCATE davis_yearly;

INSERT INTO davis_yearly (
  date_time,
  temp_out,
  hi_temp,
  low_temp,
  out_hum,
  dew_pt,
  wind_speed,
  bar,
  rain,
  solar_rad,
  uv_index
)
  SELECT
    DATE_FORMAT(d0.date_time, "%Y-01-01 00:00:00") formated_date_time,
    AVG(d0.temp_out)                               temp_out,
    MAX(d0.hi_temp)                                hi_temp,
    MIN(d0.low_temp)                               low_temp,
    AVG(d0.out_hum)                                out_hum,
    AVG(d0.dew_pt)                                 dew_pt,
    AVG(d0.wind_speed)                             wind_speed,
    AVG(d0.bar)                                    bar,
    SUM(d0.rain)                                   rain,
    AVG(d0.solar_rad)                              solar_rad,
    AVG(d0.uv_index)                               uv_index
  FROM davis_monthly d0
  GROUP BY formated_date_time
  HAVING COUNT(formated_date_time) >= 0;

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


-- -------------------------------- --
--            Triggers              --
--  ------------------------------- --
# Testados com: 
#       UnifeiCA_jun2016.txt
#       UnifeiCA_dez2016.txt
#       UnifeiCA_abr2016.txt

# Outros arquivos de 2016 retornam erros de sql, 
# Não efetuei testes com de outros anos.

# TABELA PARA AVALIAR MODA DE DIREÇÃO DO VENTO


CREATE TABLE IF NOT EXISTS mode_wind_dir(
  date_time DATETIME,
  wind_dir VARCHAR(3),
  n INT DEFAULT 0,
  PRIMARY KEY(date_time,wind_dir)
);



# FUNÇÃO PARA CALCULAR NOVA MODA DE DIREÇÂO DO VENTO
# IRA RETORNAR A QUE POSSUIR A MAIOR CONTAGEM
# Será chamada em toda trigger e retornara a nova moda



DELIMITER //
CREATE FUNCTION update_mode_wind_dir_YEAR(dtime DATETIME, wdir VARCHAR(3)) RETURNS VARCHAR(3)
BEGIN 
  DECLARE mode_wdir VARCHAR(3);
  
 # VI DEPOIS QUE O NULL ERAM '---' PARA O BANCO NÃO EFETUEI TESTES NA PARTE INFERIOR
 # REMOVA E TESTE POR FAVOR 
 -- IF wdir = '---' THEN
 --
 --    SELECT  wind_dir INTO @mode_wdir FROM mode_wind_dir WHERE 
 --   date_time = date_format(dtime,'%Y-01-01 00:00:00') ORDER BY n DESC LIMIT 1;
 --
 --   RETURN @mode_wdir;
 -- END IF;

  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
  # VERIFICANDO SE EXISTE UM REGISTRO DO [ANO,WIND_DIR] A SER INCREMENTADO
  # CASO ELE NAO EXISTA SERA CRIADO O REGISTRO E SETADO PARA 1 SUA QUANTIDADE.
  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
  IF EXISTS(SELECT date_time FROM mode_wind_dir
    WHERE date_time = date_format(dtime,'%Y-01-01 00:00:00') AND wind_dir = wdir) THEN

      UPDATE mode_wind_dir SET
        n = n+1 WHERE date_time = date_format(dtime,'%Y-01-01 00:00:00')
        AND wind_dir = wdir;

  ELSE 
      INSERT INTO mode_wind_dir VALUES(date_format(dtime,'%Y-01-01 00:00:00'),
                                       wdir,
                                       1);
      RETURN wdir;

  END IF;
  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
  # AGORA JA TEMOS OS VALORES ATUALIZADOS, IREMOS FAZER UMA QUERY PARA DETERMINAR
  # A DIREÇÃO ATUAL NA MODA E RETORNÁ-LA A TRIGGER
  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
   SELECT  wind_dir INTO @mode_wdir FROM mode_wind_dir WHERE 
    date_time = date_format(dtime,'%Y-01-01 00:00:00') AND wind_dir != '---' ORDER BY n DESC LIMIT 1;
  
  RETURN @mode_wdir;
END; // 
DELIMITER ;


DELIMITER //
CREATE TRIGGER tr_populate_davis_yearly BEFORE INSERT ON davis
FOR EACH ROW
BEGIN 
  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
  # DECLARAR E ATRIBUIR ATRAVÉS DA FUNÇÃO DE MODA O VALOR DA DIREÇÃO DO VENTO
  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
   DECLARE mode_wdir VARCHAR(3);

   SELECT update_mode_wind_dir_YEAR(NEW.date_time,NEW.wind_dir) INTO @mode_wdir;
  
  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
  # VERIFICANDO SE EXISTE UM REGISTRO DO ANO A SER ATUALIZADO, CASO ELE NÃO
  # EXISTA SERA CRIADO O REGISTRO E SETADO PARA O PRIMEIRO ADICIONADO
  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
   IF EXISTS(SELECT date_time FROM davis_yearly WHERE date_time = date_format(new.date_time,'%Y-01-01 00:00:00')) THEN

  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
  # APLICANDO AS FUNÇÕES ESTATISTICAS PARA O NOVO VALOR 
  # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
    UPDATE davis_yearly SET 
      temp_out = ((temp_out * numberOfData) + NEW.temp_out)/(numberOfData+1),
      hi_temp  = GREATEST(hi_temp, NEW.hi_temp),
      low_temp = LEAST(low_temp, NEW.low_temp),
      out_hum = ((out_hum * numberOfData) + NEW.out_hum)/(numberOfData+1),
      dew_pt = ((dew_pt * numberOfData) + NEW.dew_pt)/(numberOfData+1),
      wind_speed = ((wind_speed * numberOfData) + NEW.wind_speed)/(numberOfData+1),
      bar = ((bar * numberOfData) + NEW.bar)/(numberOfData+1),
      rain = rain + NEW.rain,
      solar_rad = ((solar_rad * numberOfData) + NEW.solar_rad)/(numberOfData+1),
      uv_index = ((uv_index * numberOfData) + NEW.uv_index)/(numberOfData+1),
      numberOfData = numberOfData +1,
      wind_dir = @mode_wdir
      WHERE date_time = date_format(new.date_time,'%Y-01-01 00:00:00');
    
    ELSE 
    
    INSERT INTO davis_yearly (date_time, 
                              temp_out,
                              hi_temp,
                              low_temp,
                              out_hum,
                              dew_pt,
                              wind_speed,
                              bar,
                              rain,
                              solar_rad,
                              uv_index,
                              numberOfData,
                              wind_dir) VALUES
                              (date_format(new.date_time,'%Y-01-01 00:00:00'),
                              NEW.temp_out,
                              NEW.hi_temp,
                              NEW.low_temp,
                              NEW.out_hum,
                              NEW.dew_pt,
                              NEW.wind_speed,
                              NEW.bar,
                              NEW.rain,
                              NEW.solar_rad,
                              NEW.uv_index,
                              1,
                              @mode_wdir);
    END IF;

END;//
DELIMITER ;







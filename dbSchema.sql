DROP PROCEDURE IF EXISTS update_table;

DELIMITER //
CREATE PROCEDURE update_table(IN tabela VARCHAR(100), IN formato VARCHAR(20))
  BEGIN

    SET @tabela = tabela;
    SET @formato = formato;

    DROP TABLE IF EXISTS temp_table;

    CREATE TEMPORARY TABLE IF NOT EXISTS temp_table (
      formated_date_time DATETIME PRIMARY KEY,
      wind_dir           VARCHAR(3),
      n                  INT
    ) AS (
      SELECT
        formated_date_time,
        d1.wind_dir,
        MAX(d1.n) n
      FROM (
             SELECT
               DATE_FORMAT(d0.date_time, formato) formated_date_time,
               d0.wind_dir                        wind_dir,
               COUNT(d0.wind_dir)                 n
             FROM davis d0
             GROUP BY formated_date_time, d0.wind_dir
             ORDER BY formated_date_time, COUNT(d0.wind_dir) DESC
           ) d1
      GROUP BY d1.formated_date_time
    );

    SET @q = CONCAT('TRUNCATE ', @tabela);
    PREPARE stmt FROM @q;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;

    SET @q = CONCAT('INSERT INTO ', @tabela, ' (
      date_time,
      temp_out,
      hi_temp,
      low_temp,
      out_hum,
      dew_pt,
      wind_speed,
      wind_dir,
      bar,
      rain,
      solar_rad,
      uv_index
    )
      SELECT
        DATE_FORMAT(d0.date_time, "', @formato, '") formated_date_time,
        AVG(d0.temp_out)                   temp_out,
        MAX(d0.hi_temp)                    hi_temp,
        MIN(d0.low_temp)                   low_temp,
        AVG(d0.out_hum)                    out_hum,
        AVG(d0.dew_pt)                     dew_pt,
        AVG(d0.wind_speed)                 wind_speed,
        tt.wind_dir                        wind_dir,
        AVG(d0.bar)                        bar,
        SUM(d0.rain)                       rain,
        AVG(d0.solar_rad)                  solar_rad,
        AVG(d0.uv_index)                   uv_index
      FROM davis d0
        JOIN temp_table tt ON tt.formated_date_time = DATE_FORMAT(d0.date_time, "', @formato, '")
      GROUP BY formated_date_time
      HAVING COUNT(formated_date_time) >= 0;
    ');

    PREPARE stmt FROM @q;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;

    DROP TABLE IF EXISTS temp_table;
  END;
//

DROP PROCEDURE IF EXISTS atualiza_tabelas;

DELIMITER //
CREATE PROCEDURE atualiza_tabelas()
  BEGIN
    CALL update_table("davis_hourly", "%Y-%m-%d %H:00:00");
    CALL update_table("davis_daily", "%Y-%m-%d 00:00:00");
    CALL update_table("davis_monthly", "%Y-%m-01 00:00:00");
    CALL update_table("davis_yearly", "%Y-01-01 00:00:00");
  END;
//

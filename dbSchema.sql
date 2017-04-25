select avg(tempOut) from davis d 
where d.dateTime between '2010-05-01 00:00:00' and ' 2010-05-01 00:59:59'; 


SELECT avg(temOut) FROM davis d GROUP BY 
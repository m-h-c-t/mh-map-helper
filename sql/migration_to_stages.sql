# Import stages table first

UPDATE locations l, stages s
SET l.stage = s.id
WHERE l.stage = s.name;

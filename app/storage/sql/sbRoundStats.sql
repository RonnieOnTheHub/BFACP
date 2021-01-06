SELECT *
FROM tbl_mapstats
WHERE ServerID = ?
  AND round_id =
    (SELECT MAX(ID)
     FROM tbl_mapstats
     WHERE ServerID = ?)

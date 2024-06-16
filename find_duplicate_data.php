Which query would you write to find every duplicate in a table? You should
mention possible methods.

Solution:

1.Select col1, col2 COUNT(*) from table_name group by col1, col2 having count(*)>1;

2. SELECT t1.* FROM my_table t1 JOIN my_table t2 ON t1.name = t2.name AND t1.email = t2.email
AND t1.id <> t2.id;


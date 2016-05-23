

---------------
---------------



DROP PROCEDURE IF EXISTS reg_user;

delimiter |

CREATE PROCEDURE reg_user(IN in_login VARCHAR(20), 
								IN in_pass VARCHAR(20),
								IN in_mail VARCHAR(30)
								)
	BEGIN
		DECLARE dec_true_login VARCHAR(20);
		DECLARE dec_user_id MEDIUMINT UNSIGNED;
		
		/*  IF not user - dec_true_login = NULL  */
		SELECT login FROM users 
			WHERE login = in_login LIMIT 1
			INTO dec_true_login;
		
		/*  IF is no user - INSERT user, return true  */
		IF dec_true_login IS NULL THEN
			INSERT INTO users (login, password)
				VALUES (in_login, in_pass);
			SELECT LAST_INSERT_ID()	INTO dec_user_id;
			INSERT INTO email (mail, user_id)
				VALUES (in_mail, dec_user_id);
			SELECT 'true';
				
		/*  IF is user - NOT INSERT, return false  */
		ELSE
			SELECT 'false';
		END IF;
	END;|

delimiter ;



CALL reg_user('test', 'test', 'test');





---------------
---------------




-- TEST --


DROP PROCEDURE IF EXISTS reg;

delimiter |

CREATE PROCEDURE sel_int (IN par1 INT, IN par2 INT)
	BEGIN
		SELECT par1;
	END |
	
delimiter ;



---------------
---------------
--Если SELECT ничего не находит - возвращается NULL.


DROP PROCEDURE IF EXISTS reg;

delimiter |

CREATE PROCEDURE reg (IN par1 VARCHAR(20), 
						IN par2 VARCHAR(20) )
	BEGIN
		DECLARE dec_param VARCHAR(20);
		
		SELECT title FROM products 
			WHERE title = 'tit' INTO dec_param;
			
		SELECT dec_param;
		
		IF dec_param IS NULL THEN
			SELECT 'NULL...';
			END IF;
			END |
			SELECT 'AFTER END';
		ELSE
			SELECT 'ARE...';
			END IF;
			END |
			SELECT 'AFTER END';
		END IF;
	END |

delimiter ;


CALL reg('a','2');



---------------
---------------




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
			INSERT INTO email (email, user_id)
				VALUES (in_mail, dec_user_id);
			SELECT 'true';
				
		/*  IF is user - NOT INSERT, return false  */
		ELSE
			SELECT 'false';
		END IF;
	END;|

delimiter ;
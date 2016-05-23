

---------------
---------------



DROP PROCEDURE IF EXISTS set_products;

delimiter |

CREATE PROCEDURE set_products(IN in_category VARCHAR(20), 
								IN in_title VARCHAR(20),
								IN in_price SMALLINT,
								IN file_type VARCHAR(20)
								)
	BEGIN
		DECLARE dec_product_id MEDIUMINT UNSIGNED;
		DECLARE dec_file_dir_final VARCHAR(30);
		INSERT INTO products (category, title, price)
			VALUES(in_category, in_title, in_price);
		IF file_type <> '' THEN
			SELECT LAST_INSERT_ID() INTO dec_product_id;
			SELECT CONCAT('img/', dec_product_id, file_type)
				INTO dec_file_dir_final;
			UPDATE products
				SET img = dec_file_dir_final
				WHERE product_id = dec_product_id;
			SELECT dec_file_dir_final AS file_dir_final;
		ELSE
			SET dec_file_dir_final = '';
			SELECT dec_file_dir_final AS file_dir_final;
		END IF;
	END;|

delimiter ;

CALL set_products('test', 'test', 111, 'test');




---------------
---------------





-- TEST --


DROP PROCEDURE IF EXISTS sel_int;

delimiter |

CREATE PROCEDURE sel_int (IN par1 INT, IN par2 INT)
	BEGIN
		SELECT par1;
	END |
	
delimiter ;

---------------
---------------


DROP PROCEDURE IF EXISTS sel_int;

delimiter |

CREATE PROCEDURE sel_int (IN par1 INT, IN par2 INT, )
	BEGIN
		IF par2 <> '' THEN
			SELECT par1;
		ELSE
			SELECT par2;
		END IF;
	END |

delimiter ;


---------------
---------------


CALL sel_int(1, '2');
CREATE EVENT e_validar_token
    ON SCHEDULE
      EVERY 1 HOUR
    COMMENT 'Invalidar tokens com mais de 1 dia de existência'
    DO
      UPDATE recuperacao_conta rc SET rc.valido = 0 WHERE rc.data < NOW() - INTERVAL 1 DAY;
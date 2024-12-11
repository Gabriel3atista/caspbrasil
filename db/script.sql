-- Criando tabela de notas fiscais
CREATE TABLE nfe (
    id SERIAL PRIMARY KEY,
    nr_nfe INT NOT NULL,
);

-- Criando tabela de produtos
CREATE TABLE produtos (
    id SERIAL PRIMARY KEY,
    ds_produto VARCHAR(255) NOT NULL,
    nr_quantidade INT NOT NULL,
    vl_produto INT NOT NULL
);

CREATE TABLE nfe_produto (
    id_nfe INT NOT NULL,
    id_produto INT NOT NULL,
    nr_quantidade_produto INT NOT NULL,
    vl_nfe INT NOT NULL
    -- Relacionando as tabelas nfe e produto e definindo uma chave primária composta para não ter duplicações
    PRIMARY KEY (id_nfe, id_produto),
    FOREIGN KEY (id_nfe) REFERENCES nfe(id),
    FOREIGN KEY (id_produto) REFERENCES produto(id)
);

-- Listando uma nota contendo um produto e a quantidade
SELECT 
    np.id_nfe,
    n.nr_nfe,
    np.nr_quantidade_produto,
    np.vl_nfe,
    p.id AS id_produto,
    p.ds_produto,
    p.nr_quantidade,
    p.vl_produto
FROM nfe_produto np
JOIN nfe n ON np.id_nfe = n.id
JOIN produto p ON np.id_produto = p.id
WHERE np.id_nfe = 1;

-- Populando as tabelas criadas 
INSERT INTO nfe (nr_nfe) VALUES (100);
INSERT INTO produto (ds_produto, nr_quantidade, vl_produto) VALUES ("Notebook Dell", 1, 1500);
INSERT INTO nfe_produto (id_nfe, id_produto, nr_quantidade_produto, vl_nfe) VALUES (1, 1, 4, 3800);

-- Trigger que será disparada para recalcular o valor da nfe
CREATE OR REPLACE TRIGGER tg_atualizar_valor_nfe
AFTER INSERT OR UPDATE OR DELETE
ON nfe_produto
FOR EACH ROW
DECLARE
    valor_total INT;
BEGIN
    -- Script responsável pelo cálculo do valor total da nfe com base na quantidade de produtos e o valor do produto
    SELECT SUM(np.nr_quantidade_produto * p.vl_produto)
    INTO valor_total
    FROM nfe_produto np
    JOIN produtos p ON np.id_produto = p.id
    WHERE np.id_nfe = :NEW.id_nfe OR np.id_nfe = :OLD.id_nfe;

    -- Atualiza o valor_total da nfe
    UPDATE nfe
    SET vl_nfe = valor_total
    WHERE id = :NEW.id_nfe OR id = :OLD.id_nfe;
END;
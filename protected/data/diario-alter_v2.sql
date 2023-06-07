SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER SCHEMA `diario`  DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_bin ;

ALTER TABLE `diario`.`aluno` 
ENGINE = InnoDB ,
CHANGE COLUMN `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `instituicao_id` `instituicao_id` BIGINT(20) NOT NULL ;

ALTER TABLE `diario`.`instituicao` 
ENGINE = InnoDB ,
CHANGE COLUMN `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,
ADD COLUMN `responsavel_id` BIGINT(20) NULL DEFAULT NULL AFTER `sigla`,
ADD INDEX `fk_instituicao_usuario1_idx` (`responsavel_id` ASC);

ALTER TABLE `diario`.`professor` 
ENGINE = InnoDB ,
CHANGE COLUMN `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `diario`.`curso` 
COLLATE = utf8_bin , ENGINE = InnoDB ,
CHANGE COLUMN `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `nome` `nome` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `instituicao_id` `instituicao_id` BIGINT(20) NOT NULL ,
ADD COLUMN `coordenador_id` BIGINT(20) NULL DEFAULT NULL AFTER `instituicao_id`,
ADD INDEX `fk_dia_curso_dia_professor1_idx` (`coordenador_id` ASC);

ALTER TABLE `diario`.`disciplina` 
COLLATE = utf8_bin , ENGINE = InnoDB ,
CHANGE COLUMN `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `nome` `nome` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `codigo` `codigo` VARCHAR(20) NULL DEFAULT NULL ,
CHANGE COLUMN `curso_id` `curso_id` BIGINT(20) NOT NULL ,
CHANGE COLUMN `ementa` `ementa` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `bibbasica` `bibbasica` TEXT NULL DEFAULT NULL ;

ALTER TABLE `diario`.`turma` 
COLLATE = utf8_bin , ENGINE = InnoDB ,
CHANGE COLUMN `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `professor_id` `professor_id` BIGINT(20) NOT NULL ,
CHANGE COLUMN `disciplina_id` `disciplina_id` BIGINT(20) NOT NULL ,
CHANGE COLUMN `objetivosgerais` `objetivosgerais` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `objetivosespecificos` `objetivosespecificos` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `conteudo` `conteudo` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `metodologia` `metodologia` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `recursos` `recursos` TEXT NULL DEFAULT NULL ,
CHANGE COLUMN `bibcomplementar` `bibcomplementar` TEXT NULL DEFAULT NULL ,
ADD COLUMN `sala_id` BIGINT(20) NOT NULL AFTER `publicarpe`,
ADD INDEX `fk_turma_sala1_idx` (`sala_id` ASC);

ALTER TABLE `diario`.`turma_has_aluno` 
COLLATE = utf8_bin , ENGINE = InnoDB ,
CHANGE COLUMN `turma_id` `turma_id` BIGINT(20) NOT NULL ,
CHANGE COLUMN `aluno_id` `aluno_id` BIGINT(20) NOT NULL ;

ALTER TABLE `diario`.`diario` 
COLLATE = utf8_bin , ENGINE = InnoDB ,
CHANGE COLUMN `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `conteudo` `conteudo` VARCHAR(100) NULL DEFAULT NULL ,
CHANGE COLUMN `turma_id` `turma_id` BIGINT(20) NOT NULL ;

ALTER TABLE `diario`.`diario_has_aluno` 
COLLATE = utf8_bin , ENGINE = InnoDB ,
CHANGE COLUMN `id` `id` BIGINT(20) NOT NULL ,
CHANGE COLUMN `diario_id` `diario_id` BIGINT(20) NOT NULL ,
CHANGE COLUMN `aluno_id` `aluno_id` BIGINT(20) NOT NULL ;

ALTER TABLE `diario`.`avaliacao` 
COLLATE = utf8_bin , ENGINE = InnoDB ,
CHANGE COLUMN `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `nome` `nome` VARCHAR(50) NULL DEFAULT NULL ,
CHANGE COLUMN `turma_id` `turma_id` BIGINT(20) NOT NULL ;

ALTER TABLE `diario`.`avaliacao_has_aluno` 
COLLATE = utf8_bin , ENGINE = InnoDB ,
CHANGE COLUMN `avaliacao_id` `avaliacao_id` BIGINT(20) NOT NULL ,
CHANGE COLUMN `aluno_id` `aluno_id` BIGINT(20) NOT NULL ,
CHANGE COLUMN `nota` `nota` DECIMAL(10) NULL DEFAULT NULL ,
CHANGE COLUMN `observacoes` `observacoes` VARCHAR(100) NULL DEFAULT NULL ;

ALTER TABLE `diario`.`usuario` 
COLLATE = utf8_bin , ENGINE = InnoDB ,
CHANGE COLUMN `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `nome` `nome` VARCHAR(20) NULL DEFAULT NULL ,
CHANGE COLUMN `senha` `senha` VARCHAR(20) NULL DEFAULT NULL ,
CHANGE COLUMN `papel` `papel` VARCHAR(10) NULL DEFAULT NULL ,
CHANGE COLUMN `professor_id` `professor_id` BIGINT(20) NULL DEFAULT NULL ,
CHANGE COLUMN `aluno_id` `aluno_id` BIGINT(20) NULL DEFAULT NULL ,
CHANGE COLUMN `instituicao_id` `instituicao_id` BIGINT(20) NULL DEFAULT NULL ;

CREATE TABLE IF NOT EXISTS `diario`.`documento_modelo` (
  `id` BIGINT(20) NOT NULL,
  `nome` TEXT NOT NULL,
  `conteudo` TEXT NULL DEFAULT NULL,
  `cabecalho_id` BIGINT(20) NULL DEFAULT 1,
  `rodape_id` BIGINT(20) NULL DEFAULT 2,
  `criado` DATETIME NOT NULL,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  `criador_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_modelo_documento_modelo_documento1_idx` (`cabecalho_id` ASC),
  INDEX `fk_modelo_documento_modelo_documento2_idx` (`rodape_id` ASC),
  INDEX `fk_documento_modelo_usuario1_idx` (`criador_id` ASC),
  CONSTRAINT `fk_modelo_documento_modelo_documento1`
    FOREIGN KEY (`cabecalho_id`)
    REFERENCES `diario`.`documento_modelo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_modelo_documento_modelo_documento2`
    FOREIGN KEY (`rodape_id`)
    REFERENCES `diario`.`documento_modelo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_modelo_usuario1`
    FOREIGN KEY (`criador_id`)
    REFERENCES `diario`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `diario`.`documento` (
  `id` BIGINT(20) NOT NULL,
  `nome` TEXT NOT NULL,
  `conteudo` TEXT NULL DEFAULT NULL,
  `modelo_id` BIGINT(20) NOT NULL,
  `criado` DATETIME NOT NULL,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  `criador_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_documento_documento_modelo1_idx` (`modelo_id` ASC),
  INDEX `fk_documento_usuario1_idx` (`criador_id` ASC),
  CONSTRAINT `fk_documento_documento_modelo1`
    FOREIGN KEY (`modelo_id`)
    REFERENCES `diario`.`documento_modelo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_usuario1`
    FOREIGN KEY (`criador_id`)
    REFERENCES `diario`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `diario`.`documento_historico` (
  `id` BIGINT(20) NOT NULL,
  `nome` TEXT NULL DEFAULT NULL,
  `conteudo` TEXT NULL DEFAULT NULL,
  `observacoes` TEXT NULL DEFAULT NULL,
  `aletrado` DATETIME NOT NULL,
  `documento_id` BIGINT(20) NOT NULL,
  `criador_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_documento_historico_documento1_idx` (`documento_id` ASC),
  INDEX `fk_documento_historico_usuario1_idx` (`criador_id` ASC),
  CONSTRAINT `fk_documento_historico_documento1`
    FOREIGN KEY (`documento_id`)
    REFERENCES `diario`.`documento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_historico_usuario1`
    FOREIGN KEY (`criador_id`)
    REFERENCES `diario`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `diario`.`documento_campo` (
  `id` BIGINT(20) NOT NULL,
  `modelo_id` BIGINT(20) NOT NULL,
  `nome` TEXT NOT NULL,
  `descricao` TEXT NULL DEFAULT NULL,
  `ordem` INT(11) NOT NULL,
  `tipo` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_documento_campo_documento_modelo1_idx` (`modelo_id` ASC),
  CONSTRAINT `fk_documento_campo_documento_modelo1`
    FOREIGN KEY (`modelo_id`)
    REFERENCES `diario`.`documento_modelo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `diario`.`ptd` (
  `id` BIGINT(20) NOT NULL,
  `ano` INT(11) NOT NULL,
  `semestre` INT(11) NOT NULL,
  `usuario_id` BIGINT(20) NOT NULL,
  `curso_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pdt_usuario1_idx` (`usuario_id` ASC),
  INDEX `fk_pdt_curso1_idx` (`curso_id` ASC),
  CONSTRAINT `fk_pdt_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `diario`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pdt_curso1`
    FOREIGN KEY (`curso_id`)
    REFERENCES `diario`.`curso` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `diario`.`sala` (
  `id` BIGINT(20) NOT NULL,
  `descricao` TEXT NOT NULL,
  `responsavel_instituicao_id` BIGINT(20) NULL DEFAULT NULL,
  `responsavel_curso_id` BIGINT(20) NULL DEFAULT NULL,
  `responsavel_usuario_id` BIGINT(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_sala_instituicao1_idx` (`responsavel_instituicao_id` ASC),
  INDEX `fk_sala_curso1_idx` (`responsavel_curso_id` ASC),
  INDEX `fk_sala_usuario1_idx` (`responsavel_usuario_id` ASC),
  CONSTRAINT `fk_sala_instituicao1`
    FOREIGN KEY (`responsavel_instituicao_id`)
    REFERENCES `diario`.`instituicao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sala_curso1`
    FOREIGN KEY (`responsavel_curso_id`)
    REFERENCES `diario`.`curso` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sala_usuario1`
    FOREIGN KEY (`responsavel_usuario_id`)
    REFERENCES `diario`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `diario`.`atividade_docente` (
  `id` BIGINT(20) NOT NULL,
  `nome` TEXT NOT NULL,
  `descricao` TEXT NULL DEFAULT NULL,
  `inicio` DATETIME NULL DEFAULT NULL,
  `fim` DATETIME NULL DEFAULT NULL,
  `status` INT(11) NOT NULL DEFAULT 1,
  `tipo_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_atividade_docente_atividade_tipo1_idx` (`tipo_id` ASC),
  CONSTRAINT `fk_atividade_docente_atividade_tipo1`
    FOREIGN KEY (`tipo_id`)
    REFERENCES `diario`.`atividade_tipo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `diario`.`ptd_has_atividade` (
  `id` BIGINT(20) NOT NULL,
  `ptd_id` BIGINT(20) NOT NULL,
  `atividade_id` BIGINT(20) NOT NULL,
  `ordem` VARCHAR(1) NOT NULL,
  `turno` VARCHAR(1) NOT NULL,
  INDEX `fk_pdt_has_atividade_docente_atividade_docente1_idx` (`atividade_id` ASC),
  INDEX `fk_pdt_has_atividade_docente_pdt1_idx` (`ptd_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_pdt_has_atividade_docente_pdt1`
    FOREIGN KEY (`ptd_id`)
    REFERENCES `diario`.`ptd` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pdt_has_atividade_docente_atividade_docente1`
    FOREIGN KEY (`atividade_id`)
    REFERENCES `diario`.`atividade_docente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `diario`.`reserva` (
  `id` BIGINT(20) NOT NULL,
  `sala_id` BIGINT(20) NOT NULL,
  `finalidade` TEXT NULL DEFAULT NULL,
  `inicio` DATETIME NOT NULL,
  `fim` DATETIME NOT NULL,
  `status` INT(11) NOT NULL DEFAULT 1,
  `data` DATETIME NOT NULL,
  `solicitante_id` BIGINT(20) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_reserva_sala1_idx` (`sala_id` ASC),
  INDEX `fk_reserva_usuario1_idx` (`solicitante_id` ASC),
  CONSTRAINT `fk_reserva_sala1`
    FOREIGN KEY (`sala_id`)
    REFERENCES `diario`.`sala` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reserva_usuario1`
    FOREIGN KEY (`solicitante_id`)
    REFERENCES `diario`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `diario`.`atividade_tipo` (
  `id` BIGINT(20) NOT NULL,
  `descricao` TEXT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

ALTER TABLE `diario`.`aluno` 
ADD CONSTRAINT `fk_aluno_instituicao1`
  FOREIGN KEY (`instituicao_id`)
  REFERENCES `diario`.`instituicao` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `diario`.`instituicao` 
ADD CONSTRAINT `fk_instituicao_usuario1`
  FOREIGN KEY (`responsavel_id`)
  REFERENCES `diario`.`usuario` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `diario`.`curso` 
ADD CONSTRAINT `fk_curso_instituicao`
  FOREIGN KEY (`instituicao_id`)
  REFERENCES `diario`.`instituicao` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_dia_curso_dia_professor1`
  FOREIGN KEY (`coordenador_id`)
  REFERENCES `diario`.`professor` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `diario`.`disciplina` 
ADD CONSTRAINT `fk_disciplina_curso1`
  FOREIGN KEY (`curso_id`)
  REFERENCES `diario`.`curso` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `diario`.`turma` 
ADD CONSTRAINT `fk_turma_professor1`
  FOREIGN KEY (`professor_id`)
  REFERENCES `diario`.`professor` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_turma_disciplina1`
  FOREIGN KEY (`disciplina_id`)
  REFERENCES `diario`.`disciplina` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_turma_sala1`
  FOREIGN KEY (`sala_id`)
  REFERENCES `diario`.`sala` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `diario`.`turma_has_aluno` 
ADD CONSTRAINT `fk_turma_has_aluno_turma1`
  FOREIGN KEY (`turma_id`)
  REFERENCES `diario`.`turma` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_turma_has_aluno_aluno1`
  FOREIGN KEY (`aluno_id`)
  REFERENCES `diario`.`aluno` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `diario`.`diario` 
ADD CONSTRAINT `fk_diario_turma1`
  FOREIGN KEY (`turma_id`)
  REFERENCES `diario`.`turma` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `diario`.`diario_has_aluno` 
ADD CONSTRAINT `fk_diario_has_aluno_diario1`
  FOREIGN KEY (`diario_id`)
  REFERENCES `diario`.`diario` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_diario_has_aluno_aluno1`
  FOREIGN KEY (`aluno_id`)
  REFERENCES `diario`.`aluno` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `diario`.`avaliacao` 
ADD CONSTRAINT `fk_avaliacao_turma1`
  FOREIGN KEY (`turma_id`)
  REFERENCES `diario`.`turma` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `diario`.`avaliacao_has_aluno` 
ADD CONSTRAINT `fk_avaliacao_has_aluno_avaliacao1`
  FOREIGN KEY (`avaliacao_id`)
  REFERENCES `diario`.`avaliacao` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_avaliacao_has_aluno_aluno1`
  FOREIGN KEY (`aluno_id`)
  REFERENCES `diario`.`aluno` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `diario`.`usuario` 
ADD CONSTRAINT `fk_usuario_professor1`
  FOREIGN KEY (`professor_id`)
  REFERENCES `diario`.`professor` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_usuario_aluno1`
  FOREIGN KEY (`aluno_id`)
  REFERENCES `diario`.`aluno` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_usuario_instituicao1`
  FOREIGN KEY (`instituicao_id`)
  REFERENCES `diario`.`instituicao` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

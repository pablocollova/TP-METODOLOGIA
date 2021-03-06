<?php
    namespace DAO;

    use \Exception as Exception;
    use Models\Compra as Compra;    
    use DAO\Connection as Connection;

    class CompraDAODB{

        private $connection;
        private $tableName = "compras";

        public function Add(Compra $compra){

            try
            {
                $query = "INSERT INTO ".$this->tableName." (id_tarjeta, cantidad_entradas, valor_total, id_usuario, id_funcion) VALUES (:idTarjeta, :cantidadEntradas, :valorTotal, :idUsuario, :idFuncion);";
                
                $parameters["idTarjeta"] = $compra->getIdTarjeta();
                $parameters["cantidadEntradas"] = $compra->getCantidadEntradas();
                $parameters["valorTotal"] = $compra->getValorTotal();
                $parameters["idUsuario"] = $compra->getIdUsuario();
                $parameters["idFuncion"] = $compra->getIdFuncion();

                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters);
                
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }

        public function GetAll(){
            
            try
            {
                $compraList = array();

                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {                
                    $compra = new Compra();
                    $compra->setId($row["id"]);
                    $compra->setIdTarjeta($row["id_tarjeta"]);
                    $compra->setCantidadEntradas($row["cantidad_entradas"]);
                    $compra->setValorTotal($row["valor_total"]);
                    $compra->setIdUsuario($row["id_usuario"]);
                    $compra->setIdFuncion($row["id_funcion"]);

                    array_push($compraList, $compra);
                }

                return $compraList;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }

        public function GetOne($id){

            $query = "SELECT * FROM " . $this->tableName . " WHERE id = :id";
            $parameters["id"] = $id;

            try{
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query, $parameters);

            } catch (Exception $ex){ 
                throw $ex;
            }

            if (!empty($resultSet)){
                return $this->mapear($resultSet);
            }else{
                return false;
            }
        }


        protected function mapear($value){

            $value = is_array($value) ? $value : [];
            $resp = array_map(function($p){
                return new compra($p["id"], $p["id_tarjeta"], $p["cantidad_entradas"], $p["valor_total"], $p["id_usuario"], $p["id_funcion"]);
            }, $value);

            return count($resp) > 1 ? $resp : $resp["0"];
        }


        public function lastId(){

            try{
            $query = "SELECT MAX(id) AS id FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            }
            catch(Exception $ex)
            {
                throw $ex;
            }

           return $resultSet[0]['id'];
        }

        public function recaudacionTotalCine($idCine){
            try{
                $query =
                    "SELECT IFNULL(SUM(c.valor_total),0) as recaudacion
                    FROM compras c
                    INNER JOIN funciones f
                    ON c.id_funcion = f.id_funcion
                    INNER JOIN salas s
                    ON s.id_sala = f.id_sala
                    WHERE s.id_cine = " . $idCine;

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);

                if (!empty($resultSet)){
                    
                    $row = $resultSet[0];
                    return $row["recaudacion"];
    
                }else{
                    return false;
                } 
            } catch (Exception $ex){ 
                throw $ex;
            }
        }

        public function recaudacionCineEntreFechas($idCine, $desde, $hasta){
            try{
                $query =
                    "SELECT IFNULL(SUM(c.valor_total), 0) as recaudacion
                    FROM compras c
                    INNER JOIN funciones f
                    ON c.id_funcion = f.id_funcion
                    INNER JOIN salas s
                    ON s.id_sala = f.id_sala
                    WHERE s.id_cine = :idCine
                    AND f.fecha > :desde
                    AND f.fecha < :hasta";
                
                $parameters['idCine'] = $idCine;
                $parameters['desde'] = $desde;
                $parameters['hasta'] = $hasta;

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query, $parameters);

                if (!empty($resultSet)){
                    
                    $row = $resultSet[0];
                    return $row["recaudacion"];
    
                }else{
                    return "false";
                } 
            } catch (Exception $ex){ 
                throw $ex;
            }
        }

        public function recaudacionTotalFilm($idFilm){
            try{
                $query =
                    "SELECT IFNULL(SUM(c.valor_total),0) as recaudacion
                    FROM compras c
                    INNER JOIN funciones f
                    ON c.id_funcion = f.id_funcion
                    WHERE f.id_pelicula = " . $idFilm;

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);

                if (!empty($resultSet)){
                    
                    $row = $resultSet[0];
                    return $row["recaudacion"];
    
                }else{
                    return false;
                } 
            } catch (Exception $ex){ 
                throw $ex;
            } 
        }

        public function recaudacionFilmEntreFechas($idFilm, $desde, $hasta){
            try{
                $query =
                    "SELECT IFNULL(SUM(c.valor_total),0) as recaudacion
                    FROM compras c
                    INNER JOIN funciones f
                    ON c.id_funcion = f.id_funcion
                    WHERE f.id_pelicula = :idFilm
                    AND f.fecha > :desde
                    AND f.fecha < :hasta";
                
                $parameters['idFilm'] = $idFilm;
                $parameters['desde'] = $desde;
                $parameters['hasta'] = $hasta;

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query, $parameters);

                if (!empty($resultSet)){
                    
                    $row = $resultSet[0];
                    return $row["recaudacion"];
    
                }else{
                    return false;
                } 
            } catch (Exception $ex){ 
                throw $ex;
            }
        }

    }

?>
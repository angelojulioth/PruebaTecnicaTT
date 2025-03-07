CREATE DATABASE PruebaTecnicaUsuarios
ON 
(
    NAME = PruebaTecnicaUsuarios_Data,
    FILENAME = 'C:\Data\PruebaTecnicaUsuarios_Data.mdf', -- Path for the primary data file
    SIZE = 68MB, -- Initial size
    FILEGROWTH = 10% -- Growth size
),
(
    NAME = PruebaTecnicaUsuarios_Log,
    FILENAME = 'C:\Data\PruebaTecnicaUsuarios_Log.ldf', -- Path for the log file
    SIZE = 68MB, -- Initial size
    FILEGROWTH = 10% -- Growth size
);

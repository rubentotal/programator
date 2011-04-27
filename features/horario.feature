#lang: ES
Característica: horario
  Como profesor
  Quiero poder confeccionar mis horarios
  Para poder realizar correctamente las programaciones y los seguimientos.

  Escenario: añadir asignaturas 
    Dado que estoy logeado con un usuario
    Cuando hago click en "Horarios"
    Y hago click en "Nuevo"
    Y escribo el nombre de centro "IES Abastos" en "Centro"
    Y selecciono el año "2011/2012" en "Año"
    Y hago click en "Añadir"
    Y en el pop-up selecciono un ciclo/etapa
    Y en el pop-up selecciono un curso
    Y en el pop-up selecciono una asignatura
    Y hago click en el botón "Añadir"
    Entonces debe aparecer la asignatura seleccionada en la lista.
    Y debe aparecer "IES Abastos 2010/2011" en Horarios.

  Escenario:

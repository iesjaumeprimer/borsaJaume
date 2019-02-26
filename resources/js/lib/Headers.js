const models = {
    ciclos: [
      {
        text: 'Id',
        showTable: false,
        align: 'left',
        sortable: false,
        value: 'id'
      }, { 
        text: 'Código', 
        showTable: true,
        value: 'codigo', 
        form: {
          type: 'text',
          counter: 5,
          required: true,
          rules: 'required5Rules',
        }
      }, { 
        text: 'Ciclo', 
        showTable: true,
        value: 'ciclo', 
        form: {
          type: 'text',
          counter: 50,
          required: true,
          rules: 'required50Rules',
        }
      }, { 
        text: 'Depart.', 
        showTable: true,
        value: 'cDept', 
        form: {
          type: 'text',
          counter: 50,
          required: true,
          rules: 'required50Rules',
        }
      }, { 
        text: 'Nombre', 
        showTable: true,
        value: 'cCiclo', 
        form: {
          type: 'text',
          counter: 100,
          required: true,
          rules: 'required100Rules',
        }
      }, { 
        text: 'Responsable', 
        showTable: true,
        value: 'responsable', 
        form: {
          type: 'select',
          table: 'profesores',
          show: 'nombre',
          required: true,
        }
      }
    ],
    empresas: [
      {
        text: 'Id',
        showTable: false,
        align: 'left',
        sortable: false,
        value: 'id'
      }, { 
        text: 'CIF', 
        showTable: true,
        value: 'cif', 
        form: {
          type: 'text',
          counter: 9,
          required: true,
          rules: 'requiredCifRules',
        }
      }, { 
        text: 'Nombre', 
        showTable: true,
        value: 'nombre', 
        form: {
          type: 'text',
          counter: 50,
          required: true,
          rules: 'required50Rules',
        }
      }, { 
        text: 'Domicilio', 
        showTable: false,
        value: 'domicilio', 
        form: {
          type: 'text',
          counter: 150,
          required: false,
          rules: 'required150Rules',
        }
      }, { 
        text: 'Localidad', 
        showTable: true,
        value: 'localidad', 
        form: {
          type: 'text',
          counter: 50,
          required: true,
          rules: 'required50Rules',
        }
      }, { 
        text: 'Teléfono', 
        showTable: true,
        value: 'telefono', 
        form: {
          type: 'text',
          counter: 20,
          required: true,
          rules: 'required20Rules',
        }
      }, { 
        text: 'Web', 
        showTable: false,
        value: 'web', 
        form: {
          type: 'text',
          counter: 50,
          required: true,
          rules: 'required50Rules',
        }
      }, { 
        text: 'E-mail', 
        showTable: true,
        value: 'email', 
        form: {
          type: 'text',
          counter: 50,
          required: true,
          rules: 'emailRules',
        }
      }, { 
        text: 'Descripción',
        showTable: false,
        value: 'descripcion', 
        form: {
          type: 'text',
          counter: 400,
        }
      }
    ],
    alumnos: [
      {
        text: 'Id',
        showTable: true,
        align: 'left',
        sortable: false,
        value: 'id'
      }, { 
        text: 'Nombre', 
        showTable: true,
        value: 'nombre', 
        form: {
          type: 'text',
          counter: 50,
          required: true,
          rules: 'required50Rules',
        }
      }, { 
        text: 'Apellidos', 
        showTable: true,
        value: 'apellidos', 
        form: {
          type: 'text',
          counter: 50,
          required: true,
          rules: 'required50Rules',
        }
      }, { 
        text: 'E-mail', 
        showTable: true,
        value: 'email', 
        form: {
          type: 'text',
          counter: 50,
          required: true,
          rules: 'emailRules',
        }
      }, { 
        text: 'Domicilio', 
        showTable: false,
        value: 'domicilio', 
        form: {
          type: 'text',
          counter: 150,
          required: false,
          rules: 'required150Rules',
        }
      }, { 
        text: 'Teléfono', 
        showTable: false,
        value: 'telefono', 
        form: {
          type: 'text',
          counter: 20,
          required: true,
          rules: 'required20Rules',
        }
      }, { 
        text: 'Info',
        showTable: true,
        value: 'info', 
        form: {
          type: 'checkbox',
          text: '¿Deseas recibir información del Centro?', 
        }
      }, { 
        text: 'Bolsa',
        showTable: true,
        value: 'bolsa', 
        form: {
          type: 'checkbox',
          text: '¿Deseas participar en la Bolsa de Trabajo?', 
        }
      }, { 
        showTable: false,
        value: 'acepta', 
        form: {
          type: 'checkbox',
          text: '¿Aceptas las condiciones del registro?', 
          rules: 'requiredCheckRules',
          required: true,
        }
      },
    ],
    menu: [
      {
        text: 'Id',
        showTable: true,
        align: 'left',
        value: 'id'
      }, { 
        text: 'Orden', 
        showTable: true,
        value: 'order', 
        form: {
          type: 'text',
          required: true,
          rules: 'requiredRules',
        }
      }, { 
        text: 'Texto', 
        showTable: true,
        value: 'text', 
        form: {
          type: 'text',
          counter: 50,
          required: true,
          rules: 'required50Rules',
        }
      }, { 
        text: 'Ruta', 
        showTable: true,
        value: 'path', 
        form: {
          type: 'text',
          counter: 50,
          required: true,
          rules: 'requiredPathRules',
        }
      }, { 
        text: 'Icono', 
        showTable: true,
        value: 'icon',
        sortable: false, 
        icon: true,
        form: {
          type: 'text',
          required: true,
          rules: 'requiredRules',
        }
      }, { 
        text: 'Submenús', 
        showTable: true,
        value: 'children', 
        comment: 'IDs de los ítems de su submenú',
        form: {
          type: 'text',
          required: false,
        }
      }, { 
        text: 'Desplegado', 
        showTable: true,
        value: 'model', 
        form: {
          text: 'Desplegado', 
          type: 'checkbox',
          comment: 'Si tiene hijos indica si aparece desplegado por defecto',
          required: false,
        }
      }, { 
        text: 'Icono-alt', 
        showTable: true,
        value: 'icon_alt',
        sortable: false, 
        icon: true,
        form: {
          type: 'text',
          comment: 'El icono a mostrar cuando está desplegado su submenú' ,
          required: false,
        }
      }, { 
        text: 'Rol', 
        showTable: true,
        value: 'rol', 
        form: {
          type: 'text',
          required: true,
          rules: 'requiredRules',
        }
      }, { 
        text: 'Activo', 
        showTable: true,
        value: 'active', 
        form: {
          text: 'Activo', 
          type: 'checkbox',
          comment: 'Los submenús deben estar desactivados para que no aparezcan también como ítem principal',
          required: false,
        }
      },
    ],
  }

  export default {
    getTable(model) {
      return models[model]?models[model].filter(item=>item.showTable):[];
    },
    getForm(model) {
      return models[model]?models[model].filter(item=>item.form):[];
    }
  }
  
import API from '../lib/API';
import Rols from '../lib/Rols';

export default {
    data: () => ({
        search: "",
        items: [],    
        errors: [],
        // Para el dialogo
        dialog: false,
        editItem: {},
        editIndex: -1,
        valid: true,
        // Para modificar
        admin: true,
        kk: {},
    }),
    computed: {
        isNew () {
            return this.editIndex === -1;
        },
        imAdmin() {
            return sessionStorage.user_rol=="2";
        },
        imResponsable() {
            return Number(sessionStorage.user_rol)<=3;
        },
        imEmpresa() {
            return sessionStorage.user_rol=="5";
        },
        imAlumno() {
            return sessionStorage.user_rol=="7";
        },
        myId() {
            return Number(sessionStorage.user_id);
        }
    },
    methods: {
        // Métodos de DataTable
        toggleAll () {
            if (this.selected.length) this.selected = []
            else this.selected = this.items.slice()
        },
        changeSort (column) {
            if (this.pagination.sortBy === column) {
              this.pagination.descending = !this.pagination.descending
            } else {
              this.pagination.sortBy = column
              this.pagination.descending = false
            }
        },
        loadItems() {
            API.getTable(this.table, this.$route.query)
            .then(resp => {
              this.items = resp.data.data;
            })
            .catch(err => {
                let msg='';
                switch (err.response.status) {
                  case 401:
                    sessionStorage.removeItem('access_token');
                    sessionStorage.removeItem('expires_at');
                    sessionStorage.removeItem('user_rol');
                    sessionStorage.removeItem('user_id');
                    sessionStorage.removeItem('token_type');
                    msg='Debes volverte a loguear';
                    break;
                  default:
                    msg='ERROR: '+err;
                }
                this.msgErr(msg);
  
            });
  
        },
        addItem() {
            // OJO. SObreescrito en: MenuView.vue
            console.error('addItem')
            if (this.editIndex > -1) {
                API.updateItem(this.table, this.editItem.id, this.editItem)
                .then(resp => {
                    let index = this.items.findIndex(item => item.id==resp.data.id);
                    this.items.splice(index,1,resp.data);
//                    Object.assign(this.items[this.editIndex], resp.data)
                    this.msgOk('update');
                })
                .catch(err => this.msgErr(err));
            } else {
                API.saveItem(this.table, this.editItem)
                .then(resp => {
                  this.items.push(resp.data);
                  this.msgOk('save');
                })
                .catch(err => this.msgErr(err));
            }
            this.closeDialog();
      

            // if (this.isNew) {
            //   API.saveItem(this.table, this.editItem)
            //     .then(resp => {
            //       this.items.push(resp.data);
            //       this.msgOk('save');
            //     })
            //     .catch(err => this.msgErr(err));
            // } else {
            //   API.updateItem(this.table, this.editItem.id, this.editItem)
            //     .then(resp => {
            //         let index = this.items.findIndex(item => item.id==resp.data.id);
            //         this.items.splice(index,1,resp.data);
            //       this.msgOk('update');
            //     })
            //     .catch(err => this.msgErr(err));
            // }
//        }
        },

        deleteItem(item, msg) {
            if (confirm("¿Segur que vols esborrar " + msg+ "?")) {
                const index = this.items.indexOf(item)
                API.delItem(this.table, item.id)
                .then(() => {
                  this.items.splice(index, 1);
                  this.msgOk('delete');
                })
                .catch(err => this.msgErr(err));
            }
        },      

        msgOk(action, msg) {
            switch (action) {
                case 'delete':
                    msg=msg || "Registre esborrat correctament";
                    break;
                case 'save':
                case 'update':
                    this.closeDialog();
                    msg=msg || "Dades guardades correctament";
            }
            this.errors.push({
            msg: msg,
            type: "success",
            show: true
            });
            window.scroll(0, 0);
        },
  
        msgErr(err) {
            if (this.dialog)
            this.dialog = false;
            this.errors.push({
                msg: err.data ? err.data.message : err.message || err,
                type: "error",
                show: true
            });
            window.scroll(0, 0);
        },

        delError(index) {
            this.errors.splice(index, 1);
        },

        showExpand() {
    
        },

        openDialog(item, defaultItem={}) {
            // Si recibe una id carga en el diálogo el item con ese id
            // Si no screa un nuevo item con las propiedades pasadas por defecto
            // Parámetros:
            // id: number. La id del item a editar o false si es añadir
            // defaultItem: object. Si se está añadiendo un objeto sus propiedades por defecto
            this.editIndex = this.items.findIndex(elem=>elem.id==item.id);
//            this.editIndex = this.items.indexOf(item)
            this.editItem = Object.assign({}, item);
            this.dialog = true;
    


/*             this.dialog = true;
            if (item.id) {
                this.editItem = {...item};
                this.isNew = false;
            } else {
//                if (!this.isNew) 
                    this.editItem = defaultItem; // Si estavem editant un item l'esborrem
                this.isNew = true;
            } */
        },
        
        closeDialog() {
            this.dialog = false
            setTimeout(() => {
//                this.editItem = Object.assign({}, this.defaultItem)
                this.editItem = {};
                this.editIndex = -1;
            }, 300)

//            this.editItem = {};
        },
    } 
}

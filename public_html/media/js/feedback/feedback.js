'use strict';

const endpoints = {
    get: '/api/comment/get',
    create: '/api/comment/create',
};
/**
 * This defines how JS code selects elements by ID
 */
const selectors = {
    table: 'table',
    forms: {
        create: 'comment-create-form',
    },
    modal: 'update-modal'
}

/**
 * Executes API request
 * @param {type} url Endpoint URL
 * @param {type} formData instance of FormData
 * @param {type} success Success callback
 * @param {type} fail Fail callback
 * @returns {undefined}
 */
function api(url, formData, success, fail) {
    fetch(url, {
        method: 'POST',
        body: formData
    }).then(response => response.json())
        .then(obj => {
            if (obj.status === 'success') {
                success(obj.data);
            } else {
                fail(obj.errors);
            }
        })
        .catch(e => {
            if (e.toString() == 'SyntaxError: Unexpected token < in JSON at position 0') {
                fail(['Problem is with your API controller, did not return JSON! Check Chrome->Network->XHR->Response']);
            } else {
                fail([e.toString()]);
            }
        });
}

/**
 * Form array
 * Contains all form-related functionality
 *
 * Object forms
 */
const forms = {
        /**
         * Create Form
         */
        create: {
            init: function () {
                if (this.getElement()) {
                    this.getElement().addEventListener('submit', this.onSubmitListener);
                    return true;
                }

                return false;
            },
            getElement: function () {
                return document.getElementById(selectors.forms.create);
            },
            onSubmitListener: function (e) {
                e.preventDefault();
                console.log("PREVENTAS");
                console.log(e);
                let formData = new FormData(e.target);
                formData.append('action', 'create');
                api(endpoints.create, formData, forms.create.success, forms.create.fail);
            },
            success: function (data) {
                const element = forms.create.getElement();

                const option = forms.create.getElement().querySelector('option[value="' + data.id + '"]');
                option.remove();

                table.row.append(data);
                forms.ui.errors.hide(element);
                forms.ui.clear(element);
                forms.ui.flash.class(element, 'success');
            },
            fail: function (errors) {
                forms.ui.errors.show(forms.create.getElement(), errors);
            }
        },
        /**
         * Update Form
         */
        update: {
            init: function () {
                if (this.elements.form()) {
                    this.elements.form().addEventListener('submit', this.onSubmitListener);

                    const closeBtn = forms.update.elements.modal().querySelector('.close');
                    closeBtn.addEventListener('click', forms.update.onCloseListener);
                    return true;
                }

                return false;
            }
            ,
            elements: {
                form: function () {
                    return document.getElementById(selectors.forms.update);
                }
                ,
                modal: function () {
                    let modal = document.getElementById(selectors.modal);

                    if (!modal) {
                        throw Error('Update modal was not found, check selector: ' + selectors.modal);
                    }

                    return modal;
                }
            }
            ,
            onSubmitListener: function (e) {
                e.preventDefault();
                let formData = new FormData(e.target);
                let id = forms.update.elements.form().getAttribute('data-id');
                formData.append('id', id);
                formData.append('action', 'update');

                api(endpoints.update, formData, forms.update.success, forms.update.fail);
            }
            ,
            success: function (data) {
                table.row.update(data);
                forms.update.hide();
            }
            ,
            fail: function (errors) {
                forms.ui.errors.show(forms.update.elements.form(), errors);
            }
            ,
            fill: function (data) {
                forms.ui.fill(forms.update.elements.form(), data);
            }
            ,
            onCloseListener: function (e) {
                forms.update.hide();
            }
            ,
            show: function () {
                this.elements.modal().style.display = 'block';
            }
            ,
            hide: function () {
                this.elements.modal().style.display = 'none';
            }
        }
        ,
        /**
         * Common/Universal Form UI Functions
         */
        ui: {
            init: function () {
                // Function has to exist
                // since we're calling init() for
                // all elements withing forms object
                return true;
            }
            ,
            /**
             * Fills form fields with data
             * Each data index corelates with input name attribute
             *
             * @param {Element} form
             * @param {Object} data
             */
            fill: function (form, data) {
                console.log('Filling form fields with:', data);
                form.setAttribute('data-id', data.id);

                Object.keys(data).forEach(data_id => {
                    if (form[data_id]) {
                        const input = form.querySelector('input[name="' + data_id + '"]');
                        if (input) {
                            input.value = data[data_id];
                        } else {
                            console.log('Could not fill field ' + data_id + 'because it wasn`t found in form');
                        }
                    }
                });
            }
            ,
            clear: function (form) {
                let fields = form.querySelectorAll('[name]')
                fields.forEach(field => {
                    field.value = '';
                });
            }
            ,
            flash:
                function (element, class_name) {
                    const prev = element.className;

                    element.className += class_name;
                    setTimeout(function () {
                        element.className = prev;
                    }, 1000);

                },
            /**
             * Form-error related functionality
             */
            errors: {
                /**
                 * Shows errors in form
                 * Each error index correlates with input name attribute
                 *
                 * @param {Element} form
                 * @param {Object} errors
                 */
                show: function (form, errors) {
                    console.log(form);
                    this.hide(form);

                    console.log('Form errors received', errors);

                    Object.keys(errors).forEach(function (error_id) {
                        const field = form.querySelector('input[name="' + error_id + '"]');
                        if (field) {
                            const span = document.createElement("span");
                            span.className = 'field-error';
                            span.innerHTML = errors[error_id];
                            field.parentNode.append(span);

                            console.log('Form error in field: ' + error_id + ':' + errors[error_id]);
                        }
                    });
                }
                ,
                /**
                 * Hides (destroys) all errors in form
                 * @param {type} form
                 */
                hide: function (form) {
                    const errors = form.querySelectorAll('.field-error');
                    if (errors) {
                        errors.forEach(node => {
                            node.remove();
                        });
                    }
                }
            }
        }
    }
;
/**
 * Table-related functionality
 */
const table = {
    getElement: function () {
        return document.getElementsByClassName(selectors.table)[0];
    },
    init: function () {
        if (this.getElement()) {
            console.log('Table init')
            this.data.load();

            Object.keys(this.buttons).forEach(buttonId => {
                let success = table.buttons[buttonId].init();
                console.log('Setting up button listeners "' + buttonId + '": ' + (success ? 'PASS' : 'FAIL'));
            });

            return true;
        }

        return false;
    },
    /**
     * Data-Related functionality
     */
    data: {
        /**
         * Loads data and populates table from API
         * @returns {undefined}
         */
        load: function () {
            console.log('Table: Calling API to get data...');
            api(endpoints.get, null, this.success, this.fail);
        },
        success: function (data) {
            Object.keys(data).forEach(i => {
                table.row.append(data[i]);
            });
        },
        fail: function (errors) {
            console.log(errors);
        }
    },
    /**
     * Operations with rows
     */
    row: {
        /**
         * Builds row element from data
         *
         * @param {Object} data
         * @returns {Element}
         */
        build: function (data) {
            const row = document.createElement('tr');

            if (data.id == null) {
                throw Error('JS can`t build the row, because API data doesn`t contain its ID. Check API controller!');
            }

            row.setAttribute('data-id', data.id);
            row.className = 'data-row';
            delete (data.id);

            Object.keys(data).forEach(data_id => {
                switch (data_id) {

                    case 'buttons':
                        let buttons = data[data_id];
                        Object.keys(buttons).forEach(button_id => {
                            let td = document.createElement('td');
                            let btn = document.createElement('button');
                            btn.innerHTML = buttons[button_id];
                            btn.className = button_id;
                            td.append(btn);
                            row.append(td);
                        });
                        break;

                    default:
                        let td = document.createElement('td');
                        td.innerHTML = data[data_id];
                        td.className = data_id;
                        row.append(td);
                }
            });

            return row;
        },
        /**
         * Appends row to table from data
         *
         * @param {Object} data
         */
        append: function (data) {
            console.log('Table: Creating row in table from ', data);
            table.getElement().append(this.build(data));
        },
        /**
         * Updates existing item in grid from data
         * Row is selected via "id" index in data
         *
         * @param {Object} data
         */
        update: function (data) {
            let row = table.getElement().querySelector('.data-row[data-id="' + data.id + '"]');
            row.replaceWith(this.build(data));
            //row = this.build(data);
        },
        /**
         * Deletes existing item
         * @param {Integer} id
         */
        delete: function (id) {
            const item = table.getElement().querySelector('.data-row[data-id="' + id + '"]');
            item.remove();
        }
    },

    // Buttons are declared on whole table, not on each row individually, so
    // onClickListeners dont duplicate
    buttons: {
        edit: {
            init: function () {
                if (table.getElement()) {
                    table.getElement().addEventListener('click', this.onClickListener);
                    return true;
                }

                return false;
            },
            onClickListener: function (e) {
                if (e.target.className === 'edit') {
                    let formData = new FormData();

                    let row = e.target.closest('.data-row');
                    console.log('Edit button clicked on', row);

                    formData.append('id', row.getAttribute('data-id'));
                    api(endpoints.edit, formData, table.buttons.edit.success, table.buttons.edit.fail);
                }
            },
            success: function (api_data) {
                forms.update.show();
                forms.update.fill(api_data);
            },
            fail: function (errors) {
                alert(errors[0]);
            }
        },
        delete: {
            init: function () {
                if (table.getElement()) {
                    table.getElement().addEventListener('click', this.onClickListener);
                    return true;
                }

                return false;
            },
            onClickListener: function (e) {
                // Listener is set on whole grid, so we listen for which class button
                // has been pressed
                if (e.target.className === 'delete') {
                    let formData = new FormData();

                    // Find container of the button, which has ID
                    let item = e.target.closest('.data-row');
                    console.log('Delete button clicked on', item);

                    formData.append('id', item.getAttribute('data-id'));
                    api(endpoints.delete, formData, table.buttons.delete.success, table.buttons.delete.fail);
                }
            },
            success: function (data) {
                table.row.delete(data.id);

                const select = forms.create.getElement().querySelector('select');
                const option = document.createElement('option');

                option.value = data.id;
                option.text = data.name;
                select.append(option);
            },
            fail: function (errors) {
                alert(errors[0]);
            }
        },
    }
};


/**
 * Core page functionality
 */
const app = {
    init: function () {
        // Initialize all forms
        Object.keys(forms).forEach(formId => {
            let success = forms[formId].init();
            console.log('Initializing form "' + formId + '": ' + (success ? 'SUCCESS' : 'FAIL'));
        });

        console.log('Initializing table...');
        let success = table.init();
        console.log('Table: Initialization: ' + (success ? 'PASS' : 'FAIL'));
    }
};

// Launch App
console.log('FEEDBACK vidus');
app.init();
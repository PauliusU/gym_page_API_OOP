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
            let formData = new FormData(e.target);
            formData.append('action', 'create');
            console.log(formData);
            api(endpoints.create, formData, forms.create.success, forms.create.fail);
        },
        success: function (data) {
            const element = forms.create.getElement();

            table.row.append(data);
            forms.ui.errors.hide(element);
            forms.ui.clear(element);
            forms.ui.flash(element, 'success');
        },
        fail: function (errors) {
            forms.ui.errors.show(forms.create.getElement(), errors);
        }
    },
    /**
     * Common/Universal Form UI Functions
     */
    ui: {
        init: function () {
            // Function has to exist
            // since we're calling init() for
            // all elements withing forms object
            return true;
        },
        clear: function (form) {
            let fields = form.querySelectorAll('[name]')
            fields.forEach(field => {
                field.value = '';
            });
        },
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
                    const field = form.querySelector('textarea[name="' + error_id + '"]');
                    console.log(field);
                    if (field) {
                        const paragraph = document.createElement("p");
                        paragraph.className = 'field-error';
                        paragraph.innerHTML = errors[error_id];
                        field.parentNode.append(paragraph);

                        console.log('Form error in field: ' + error_id + ':' + errors[error_id]);
                    }
                });
            },
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
};

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
app.init();
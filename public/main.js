        removeApiForm();

        function deleteButtonHandler() {
            console.log("hellloooo");
        }

        function removeApiForm() {
            const apiForm = document.getElementById('apiForm');
            const note = document.getElementById('note');
            const successMessage = document.getElementById('success');

            if(successMessage) {
                note.style.display = "none";
                apiForm.style.display = "none";
            }


        }

        function populatesFormFields(btn) {
            const buttonType = btn.innerText;
            const fieldsList = btn.parentElement.parentElement.getElementsByTagName("td");

            document.getElementById('fieldID').value = fieldsList[0].innerText
            document.getElementById('numbtrees').value = fieldsList[1].innerText            
            document.getElementById('agetrees').value = fieldsList[2].innerText            
        }


        

        function onIdClicked(idEl) {
            const deleteBtn = idEl.parentElement.querySelector('td:nth-of-type(5)').children[0].children[2]
            const hiddenFieldID = idEl.parentElement.querySelector('input')
       
            setFieldID(idEl);
            toggleBtn(deleteBtn);
        }

        function toggleBtn(btn) {
            if( btn.attributes.getNamedItem('disabled') !== null) {
                btn.attributes.removeNamedItem('disabled')
                btn.style.removeProperty('border-color')
                btn.style.removeProperty('color')
            } else {
                btn.setAttribute("disabled", "")
                btn.style.borderColor = "#d5a3a8"
                btn.style.color = "#b76870"
            }
        }

        function setFieldID(id) {
            const hiddenFieldID = id.parentElement.querySelector('input')
            hiddenFieldID.value = id.parentElement.querySelector('td:nth-of-type(1)').innerText
        }


        // function deleteRow() {

        //     axios.post('.', {
        //         fieldID: '',
        //         delete: 'Flintstone'
        //     })
        //     .then(function (response) {
        //         console.log(response);
        //     })
        //     .catch(function (error) {
        //         console.log(error);
        //     });
        // }
        // document.getElementById('test').parentElement.childNodes[8].children[0].children[2]
        
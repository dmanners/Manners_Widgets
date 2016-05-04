varienGridMassaction = Class.create(
    varienGridMassaction,
    {
        textString: ''
    }
);

varienGridMassaction.addMethods(
    {
        onGridRowClick: function(grid, evt) {
            var tdElement = Event.findElement(evt, 'td');
            var trElement = Event.findElement(evt, 'tr');

            var trChildren = trElement.children;
            var gridName = trChildren[trChildren.length - 1].innerHTML.trim();
            if (!$(tdElement).down('input')) {
                if ($(tdElement).down('a') || $(tdElement).down('select')) {
                    return;
                }
                if (trElement.title) {
                    setLocation(trElement.title);
                }
                else {
                    console.log('else');
                    var checkbox = Element.select(trElement, 'input');
                    var isInput = Event.element(evt).tagName == 'input';
                    var checked = isInput ? checkbox[0].checked : !checkbox[0].checked;

                    if (checked) {
                        this.checkedString = varienStringArray.add(checkbox[0].value, this.checkedString);
                        this.textString = varienStringArray.add(checkbox[0].value, this.textString);
                    } else {
                        this.checkedString = varienStringArray.remove(checkbox[0].value, this.checkedString);
                        this.textString = varienStringArray.remove(checkbox[0].value, this.textString);
                    }
                    this.grid.setCheckboxChecked(checkbox[0], checked);
                    this.updateCount();
                }
                return;
            }

            if (Event.element(evt).isMassactionCheckbox) {
                this.setTextValue(Event.element(evt), gridName);
                this.setCheckbox(Event.element(evt));
            } else if (checkbox = this.findCheckbox(evt)) {
                checkbox.checked = !checkbox.checked;
                this.setTextValue(checkbox, gridName);
                this.setCheckbox(checkbox);
            }
        },
        setTextValue: function(checkbox, textValue) {
            if(checkbox.checked) {
                this.textString = varienStringArray.add(textValue, this.textString);
            } else {
                this.textString = varienStringArray.remove(textValue, this.textString);
            }
        },
        initTextValue: function(textValue) {
            this.textString = textValue;
        },
        getTextValue: function() {
            return this.textString;
        }
    }
);
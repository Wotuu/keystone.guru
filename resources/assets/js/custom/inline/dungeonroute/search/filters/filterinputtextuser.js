class SearchFilterUser extends SearchFilterInputText {
    constructor(selector, onChange) {
        super({
            selector: selector,
            onChange: onChange
        });
    }

    getFilterHeaderText() {
        return lang.get('messages.filter_input_user_header').replace(':number', this.getValue());
    }
}

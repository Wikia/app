describe("editor tests", function(){

    var editor = modules.editor();
    //creating a plain textarea for textView manipulation tests
    editor.textView = createNode('TEXTAREA');

    //returned properties and functions should be defined;
    it("should be defined"){
        expect(editor.init).toBeDefined();
        expect(editor.watcher).toBeDefined();
        expect(editor.insert).toBeDefined();
        expect()
        expect(editor.textView).toBeDefined();
    }

    //initializer should be a function
    it("should be a function"){
        expect(typeof editor.init).toBe(function);
    }

    //object storing states of snippets, tag closing and suggestions states
    it("should be an object"){
        expect(typeof editor.watcher).toBe('object');
    }

    it("should have watching properties set to false"){
        expect(editor.watcher.snippet).toBe(false);
        expect(editor.watcher.tag).toBe(false);
        expect(editor.watcher.suggestions).toBe(false);
    }

    //function inserting phrases to textView
    it("should be a function"){
        expect(typeof editor.insert).toBe('function');
    }

    it("should handle situation when feeded with undefined"){
        expect(editor.insert(undefined)).not.toThrow();
    }

    it("should modify the value of textView"){
        editor.textView.value = 'fooBar';
        editor.textView.selectionStart = editor.textView.selectionEnd = 3;
        editor.insert('foo');
        expect(editor.textView.value).toMatch('foofooBar');
    }

    it("should insert tag stripped from given '_$' and insert caret at it's place"){
        //feed plain textView with a tag having caret marker '_$'
        editor.textView.value = '';
        editor.insert('<tag>_$</tag>');
        //check if marker has been removed & caret set in the right place
        expect(editor.textView.value).toBe('<tag></tag>');
        expect(editor.selectionStart).toBe(5);
        expect(editor.selectionEnd).toBe(5);
        //feed it one more time but this time with tag having no marker
        editor.insert('<tag2></tag2>');
        expect(editor.editArea.value).toBe('<tag><tag2></tag2></tag>');
        expect(editor.selectionStart).toBe(18);
        expect(editor.selectionEnd).toBe(18);
    }
});


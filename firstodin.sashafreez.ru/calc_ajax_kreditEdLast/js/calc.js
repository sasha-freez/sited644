function clear_value(obj_id, event) {
	code = (event.charCode) ? event.charCode : event.keyCode;
	if(code != 9 && code != 16){
		document.getElementById(obj_id).value = '';
	}
}


function format_price(e) {
	var target = e.target || e.srcElement;

	var cursorPos = get_cursor_position(target);
	if (cursorPos == -1) { cursorPos = 0; }
	var deltaPos = 0;

	var lengthBefore = target.value.length;
	target.value = target.value.replace(/\s+/g,'').replace(/\s+$/, '');
	target.value = format_num(target.value);
	if (!deltaPos && (target.value.length - lengthBefore) > 0) { deltaPos = target.value.length - lengthBefore; }
	if (!deltaPos && target.value[ cursorPos + deltaPos ] == ' ' && target.value[ cursorPos + deltaPos - 1 ] == ' ') { deltaPos += 2; }
	set_cursor_position(target, cursorPos + deltaPos);
	return true;
}


function get_cursor_position(inputEl) {
	if (document.selection && document.selection.createRange) {
		var range = document.selection.createRange().duplicate();
		if (range.parentElement() == inputEl) {
			range.moveStart('textedit', -1);
			return range.text.length;
		}
	} 
	else if (inputEl.selectionEnd) { return inputEl.selectionEnd; }
	else
		return -1;
}


function set_cursor_position(inputEl, position) {
	if (inputEl.setSelectionRange) {
		inputEl.focus();
		inputEl.setSelectionRange(position, position);
	}
	else if (inputEl.createTextRange) {
		var range = inputEl.createTextRange();
		range.collapse(true);
		range.moveEnd('character', position);
		range.moveStart('character', position);
		range.select();
	}
}


function format_num(str) {
	var retstr = '';
	var now = 0;
	for (i = str.length - 1; i >= 0; i--) {
		if (now < 3) {
			now++;
			retstr = str.charAt(i) + retstr;
		} else {
			now = 1;
			retstr = str.charAt(i) + ' ' + retstr;
		}
	}
	return retstr;
}

<?php
declare(strict_types=1);

function attributes(array $attributes): string {
    $html = '';
    foreach ($attributes as $name=>$value) {
        if ($value === null || $value === false) continue;
        if (!preg_match('/^[a-z][a-z0-9_-]*$/i',$name)) throw new InvalidArgumentException('Invalid attribute');
        $html .= ' ' . $name . ($value === true ? '' : '="' . e($value) . '"');
    }
    return $html;
}
function button(string $label, array $options = []): string {
    $tag = isset($options['href']) ? 'a' : 'button';
    $variant = $options['variant'] ?? 'primary';
    unset($options['variant']);
    $options['class'] = 'button button--' . $variant . ' ' . ($options['class'] ?? '');
    if ($tag === 'button') $options['type'] ??= 'submit';
    return '<' . $tag . attributes($options) . '>' . e($label) . '</' . $tag . '>';
}
function field(string $name, string $label, mixed $value = '', array $options = []): string {
    $type = $options['type'] ?? 'text';
    $choices = $options['options'] ?? [];
    $hint = $options['hint'] ?? '';
    $error = $options['error'] ?? '';
    unset($options['type'],$options['options'],$options['hint'],$options['error']);
    $id = $options['id'] ?? ('field-' . $name);
    $options = ['id'=>$id,'name'=>$name,'class'=>'control'] + $options;
    $descriptions = [];
    if ($hint) $descriptions[] = $id . '-hint';
    if ($error) { $descriptions[] = $id . '-error'; $options['aria-invalid'] = 'true'; }
    if ($descriptions) $options['aria-describedby'] = implode(' ',$descriptions);
    $html = '<div class="field"><label for="' . e($id) . '">' . e($label) . (!empty($options['required']) ? ' <span aria-hidden="true">*</span>' : '') . '</label>';
    if ($type === 'textarea') {
        unset($options['min'],$options['autocomplete']);
        $options['rows'] ??= 4;
        $html .= '<textarea' . attributes($options) . '>' . e($value) . '</textarea>';
    } elseif ($type === 'select') {
        unset($options['min'],$options['maxlength'],$options['autocomplete']);
        $html .= '<select' . attributes($options) . '>';
        foreach ($choices as $key=>$text) $html .= '<option' . attributes(['value'=>(string)$key,'selected'=>(string)$key===(string)$value]) . '>' . e($text) . '</option>';
        $html .= '</select>';
    } else {
        if ($type !== 'number') unset($options['min']);
        if (in_array($type,['file','date','number'],true)) unset($options['maxlength']);
        $options['type'] = $type;
        if (!in_array($type,['password','file'],true)) $options['value'] = $value;
        $html .= '<input' . attributes($options) . '>';
        if ($type === 'password') $html .= button('Show password',['type'=>'button','variant'=>'quiet','data-password'=>$id,'aria-pressed'=>'false','class'=>'password-toggle']);
    }
    if ($hint) $html .= '<small id="' . e($id) . '-hint">' . e($hint) . '</small>';
    if ($error) $html .= '<small class="field-error" id="' . e($id) . '-error">' . e($error) . '</small>';
    return $html . '</div>';
}
function checkbox(string $name, string $label, bool $checked = false): string {
    return '<label class="check"><input' . attributes(['type'=>'checkbox','name'=>$name,'value'=>'1','checked'=>$checked]) . '><span>' . e($label) . '</span></label>';
}
function badge(string $text): string { return '<span class="badge">' . e($text) . '</span>'; }
function empty_state(string $title, string $description): string { return '<div class="empty-state"><h2>' . e($title) . '</h2><p>' . e($description) . '</p></div>'; }
function action_form(string $action, string $resource, string $id, string $text, string $variant = 'quiet', bool $confirm = false): string {
    return '<form method="post" action="' . e(url('action')) . '"' . ($confirm ? ' data-confirm="' . e($text . ' this record?') . '"' : '') . '>' . csrf() . '<input type="hidden" name="action" value="' . e($action) . '"><input type="hidden" name="resource" value="' . e($resource) . '"><input type="hidden" name="id" value="' . e($id) . '">' . button($text,['variant'=>$variant]) . '</form>';
}

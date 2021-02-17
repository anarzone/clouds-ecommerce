function deleteEl(el,options){
    Swal.fire({
        title: options['title'],
        showCancelButton: true,
        confirmButtonColor: "#dd6b55",
        confirmButtonText: options['confirmText'],
        cancelButtonText: options['cancelText'],
    }).then((confirmed) => {
        if(!confirmed.value) return;
        $.ajax({
            type: "POST",
            url:  options['url'],
            success: function (response) {
                if(response.message === 'success'){
                    Swal.fire(options['successMessage'], '', 'success')
                    if('type' in options && options.type === 'category'){
                        $(el).parents('li').remove()
                    }
                    $(el).parents('tr').remove();
                }
            },
            error: function (response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Səhv...',
                    text: response.message,
                })
            }
        })
    })
}

// Slug Generator (slugify)
function slugify(string) {
    const a = 'àáâäæãåāăąəçćčđďèéêëēėęěğǵḧîïíīįìıłḿñńǹňôöòóœøōõőṕŕřßśšşșťțûüùúūǘůűųẃẍÿýžźż·/_,:;'
    const b = 'aaaaaaaaaaecccddeeeeeeeegghiiiiiiilmnnnnoooooooooprrsssssttuuuuuuuuuwxyyzzz------'
    const p = new RegExp(a.split('').join('|'), 'g')

    return string.toString().toLowerCase()
        .replace(/\s+/g, '-') // Replace spaces with -
        .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
        .replace(/&/g, '-and-') // Replace & with 'and'
        .replace(/[^\w\-]+/g, '') // Remove all non-word characters
        .replace(/\-\-+/g, '-') // Replace multiple - with single -
        .replace(/^-+/, '') // Trim - from start of text
        .replace(/-+$/, '') // Trim - from end of text
}

function buildTree(obj) {
    // get all top level parents
    let parents = obj.filter((o) => !o.parent_id);

    // loop over the parents and recursively call addChild to populate the tree
    parents.forEach((p) => {
        p.children = addChildren(p, obj);
    });

    return parents;
}

function addChildren(parent, obj) {
    let children = obj.filter((o) => o.parent_id === parent.id)
    if (children.length) {
        children.forEach((c) => {
            c.children = addChildren(c, obj);
        });
        return children;
    } else {
        return [];
    }
}



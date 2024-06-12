

let validation = {}

/**
 * 密码校验
 * @param {*} rule 
 * @param {string} value 
 * @param {*} callback 
 */
validation.password = (rule, value, callback) => {
    let reg = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/
    if (!reg.test(value) && value != '') {
        callback(new Error('密码必须是由6-20位字母+数字组合'))
    } else {
        callback()
    }
}

/**
 * 邮箱验证
 * @param {*} rule 
 * @param {string} value 
 * @param {*} callback 
 */
validation.email = (rule, value, callback) => {
    let reg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/
    if (!reg.test(value) && value != '') {
        callback(new Error('请输入正确的邮箱地址'))
    } else {
        callback()
    }
}
/**
 * 手机号码验证
 * @param {*} rule 
 * @param {string} value 
 * @param {*} callback 
 */
validation.phone = (rule, value, callback) => {
    const reg = /^[1][3-9][0-9]{9}$/;
    if (!reg.test(value) && value != '') {
        callback(new Error('请输入正确的手机号码'));
    } else {
        callback();
    }
};

/**
 * 首字母小写验证
 * @param {*} rule 
 * @param {string} value 
 * @param {*} callback 
 */
validation.lcFirst = (rule, value, callback) => {
    const reg = !/^[a-z]/;
    if (!reg.test(value.charAt(0)) && value != '') {
        callback(new Error('首字母必须小写'));
    } else {
        callback();
    }
}

/**
 * 首字母大写验证
 * @param {*} rule 
 * @param {string} value 
 * @param {*} callback 
 */
validation.ucFirst = (rule, value, callback) => {
    const reg = !/^[A-Z]/;
    if (!reg.test(value.charAt(0)) && value != '') {
        callback(new Error('首字母必须大写'));
    } else {
        callback();
    }
}

/**
 * Slug验证
 * @param {*} rule 
 * @param {string} value 
 * @param {*} callback 
 */
validation.slug = (rule, value, callback) => {
    const reg = /^([0-9a-z\_]){3,50}$/
    if (!reg.test(value) && value != '') {
        callback(new Error('请填写使用小写字母、数字、下划线的3-50位的字符串'));
    } else {
        callback();
    }
}


export default validation

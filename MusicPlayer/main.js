/* 

1. Render songs
2. Scroll top
3. play/pause/seek 
4. CD rotate
5. Next/prev
6. Random
7. Next/repeat when ended
8. Active song
9. Scroll active song into view
10. Play song when click

*/
const $ = document.querySelector.bind(document)
const $$ = document.querySelectorAll.bind(document)


const PLAYER_STORAGE_KEY = 'Simple Music player'



const playlistNode = $('.playlist')
const heading = $('header h2')
const cdThumb = $('.cd-thumb')
const audio = $('#audio')
const cdElement = $('.cd')
const playBtn = $('.btn-toggle-play')
const playerElement = $('.player')
const progressBar = $('#progress')
const nextBtn = $('.btn-next')
const prevBtn = $('.btn-prev')
const randomBtn = $('.btn-random')
const repeatBtn = $('.btn-repeat')
const songElement = $('.song')
const optionElement = $('.option')


const app = {
    currentIndex: 0,
    isPlaying: false,
    isRandom: false,
    isRepeat: false,
    config: JSON.parse(localStorage.getItem(PLAYER_STORAGE_KEY)) || {},
    setConfig: function (key, value) {
        this.config[key] = value
        localStorage.setItem(PLAYER_STORAGE_KEY, JSON.stringify(this.config))
    },
    songs: [

    ],
    render: function () {
        const htmls = this.songs.map((song, index) => {
            return `
            <div class="song ${index === this.currentIndex ? 'active' : ''}" song-index="${index}" song-id="${song.songId}">
            <div
              class="thumb"
              style="
                background-image: url('${song.image}');
              "
            ></div>
            <div class="body">
              <h3 class="title">${song.name}</h3>
              <p class="author">${song.singer}</p>
            </div>
            <a class="option" href="edit_page.php?id=${song.songId}">
                <i class="fas fa-edit"></i>
            </a>
            <a class="option" href="delete.php?id=${song.songId}">
                <i class="fas fa-times"></i>
            </a>
          </div>
            `
        })

        playlistNode.innerHTML = htmls.join('')
        // console.log(htmls.join(''))
    },
    defineProperties: function () {
        Object.defineProperty(this, 'currentSong', {
            get: function () {
                return this.songs[this.currentIndex]
            }
        })

    },
    handleEvents: function () {
        const cdWidth = cdElement.offsetWidth
        const _this = this
        // X??? l?? CD xoay / d???ng
        const cdThumbAnimation = cdThumb.animate([
            {
                transform: 'rotate(360deg)'
            }
        ], {
            duration: 10000,
            iterations: Infinity
        })
        cdThumbAnimation.pause()

        console.log(cdThumbAnimation)
        // X??? l?? ph??ng to / thu nh??? CD
        // document.onscroll = function () {
        //     const scrollTop = window.scrollY || document.documentElement.scrollTop
        //     // console.log(window.scrollY)
        //     const newCdWidth = cdWidth - scrollTop
        //     // console.log(newCdWidth)

        //     // Khi scroll nhanh qu?? th?? newCdWidth s??? ??m n??n code ??? d?????i ko ch???y
        //     cdElement.style.width = newCdWidth > 0 ? newCdWidth + 'px' : 0
        //     cdElement.style.opacity = newCdWidth / cdWidth
        // }

        // X??? l?? khi click play button
        playBtn.onclick = function () {
            if (_this.isPlaying) {
                audio.pause()
            }
            else {
                audio.play()
            }
        }
        audio.onplay = function () {
            _this.isPlaying = true
            playerElement.classList.add('playing')
            cdThumbAnimation.play()
        }
        audio.onpause = function () {
            _this.isPlaying = false
            playerElement.classList.remove('playing')
            cdThumbAnimation.pause()

        }

        // Khi ti???n ????? b??i h??t thay ?????i
        audio.ontimeupdate = function () {
            if (audio.duration) {
                const progressPercentage = Math.floor((audio.currentTime / audio.duration) * 100)
                progressBar.value = progressPercentage
            }
        }

        // Khi user seek(tua) nh???c
        // c?? bug khi tua b??? reset l???i
        progressBar.oninput = function (e) {
            const seekedTime = e.target.value / 100 * audio.duration
            audio.currentTime = seekedTime
        }

        // Khi ???n n??t next/prev 
        nextBtn.onclick = function () {
            if (_this.songs.length === 1) {
                return
            }
            else if (_this.isRandom) {
                _this.playRandomSong()
            } else {
                _this.nextSong()
            }
            audio.play()
            _this.render()
            _this.scrollToActiveSong()

        }
        prevBtn.onclick = function () {
            if (_this.songs.length === 1) {
                return
            }
            if (_this.isRandom) {
                _this.playRandomSong()
            } else {
                _this.prevSong()
            }
            audio.play()
            _this.render()
            _this.scrollToActiveSong()

        }

        // Khi ???n n??t random song
        randomBtn.onclick = function () {
            if (_this.songs.length === 1) {
                return
            }
            _this.isRandom = !_this.isRandom
            randomBtn.classList.toggle('active', _this.isRandom)
            _this.setConfig('isRandom', _this.isRandom)
        }
        // Khi song end
        audio.onended = function () {
            if (_this.isRepeat) {
                audio.play()
            } else {
                nextBtn.click()
            }
        }

        // Khi ???n n??t repeat
        repeatBtn.onclick = function () {
            _this.isRepeat = !_this.isRepeat
            repeatBtn.classList.toggle('active', _this.isRepeat)
            _this.setConfig('isRepeat', _this.isRepeat)


        }

        // L???ng nghe event click v??o playlist
        playlistNode.onclick = function (e) {
            const unplayedSong = e.target.closest('.song:not(.active)')
            const songOption = e.target.closest('.option')

            // t??m song ko c?? class active
            if (e.target.closest('.song:not(.active)') || e.target.closest('.option')) {
                // console.log(e.target)

                // X??? l?? khi click v??o song option
                if (e.target.closest('.option')) {
                    console.log(e.target.closest('.song').getAttribute('song-id'))
                    _this.requestDelete = true

                }

                // X??? l?? khi click v??o song 
                else if (e.target.closest('.song:not(.active)')) {
                    // getAttribute returns value l?? string
                    _this.currentIndex = Number(unplayedSong.getAttribute('song-index'))

                    _this.loadCurrentSong()
                    _this.render()
                    audio.play()
                }


            }
        }



    },

    scrollToActiveSong: function () {
        setTimeout(function () {
            $('.song.active').scrollIntoView({
                behaviour: 'smooth',
                block: 'nearest',

            })
        }, 300)
        // c?? bug khi active song ??? tr??n ?????u th?? b??? dashboard che m???t
    },
    loadCurrentSong: function () {

        // console.log(heading, cdThumb, audio)
        heading.textContent = this.currentSong.name
        var playingSong =
            cdThumb.style.backgroundImage = `url('${this.currentSong.image}')`
        audio.src = this.currentSong.path
    },
    loadConfig: function () {
        this.isRandom = this.config.isRandom
        this.isRepeat = this.config.isRepeat

    },
    nextSong: function () {
        this.currentIndex++
        console.log(this.currentIndex, this.songs.length)
        if (this.currentIndex >= this.songs.length) {
            this.currentIndex = 0
        }
        this.loadCurrentSong()
    },
    prevSong: function () {
        this.currentIndex--
        if (this.currentIndex < 0) {
            this.currentIndex = this.songs.length - 1
        }
        this.loadCurrentSong()
    },
    playRandomSong: function () {
        do {
            var newIndex
            newIndex = Math.floor(Math.random() * this.songs.length)
        } while (newIndex == this.currentIndex)
        this.currentIndex = newIndex
        this.loadCurrentSong()
        console.log(this.currentIndex, this.songs.length)
    },
    start: function () {
        // G??n c???u h??nh t??? config v??o ???ng d???ng
        this.loadConfig()
        // ?????nh ngh??a c??c thu???c t??nh cho object
        this.defineProperties()

        // L???ng nghe v?? x??? l?? c??c s??? ki???n trong DOM
        this.handleEvents()

        // T???i info b??i h??t ?????u ti??n v??o UI khi ch???y ???ng d???ng
        this.loadCurrentSong()

        // Render playlist
        this.render()

        // Hi???n th??? tr???ng th??i ban ?????u c???a n??t repeat v?? random
        repeatBtn.classList.toggle('active', this.isRepeat)
        randomBtn.classList.toggle('active', this.isRandom)

    }
}


"setting
"文字コードをUFT-8に設定
set fenc=utf-8
"" バックアップファイルを作らない
set nobackup
" スワップファイルを作らない
set noswapfile
" " 編集中のファイルが変更されたら自動で読み直す
set autoread
" " バッファが編集中でもその他のファイルを開けるように
set hidden
" " 入力中のコマンドをステータスに表示する
set showcmd
"
"
" " 見た目系
" " 行番号を表示
set number
" " 現在の行を強調表示
set cursorline
" " 現在の行を強調表示（縦）
"set cursorcolumn
" " 行末の1文字先までカーソルを移動できるように
set virtualedit=onemore
" " インデントはスマートインデント
set smartindent
" " ビープ音を可視化
set visualbell
" " 括弧入力時の対応する括弧を表示
set showmatch
" " ステータスラインを常に表示
set laststatus=2
" " コマンドラインの補完
set wildmode=list:longest
" " 折り返し時に表示行単位での移動できるようにする
nnoremap j gj
nnoremap k gk

" " Tab系
" " 不可視文字を可視化(タブが「▸-」と表示される)
set list listchars=tab:\▸\-
" " Tab文字を半角スペースにする
set expandtab
" " 行頭以外のTab文字の表示幅（スペースいくつ分）
set tabstop=4
" " 行頭でのTab文字の表示幅
set shiftwidth=4
"

"
" " 検索系
" " 検索文字列が小文字の場合は大文字小文字を区別なく検索する
set ignorecase
" " 検索文字列に大文字が含まれている場合は区別して検索する
set smartcase
" " 検索文字列入力時に順次対象文字列にヒットさせる
set incsearch
" " 検索時に最後まで行ったら最初に戻る
set wrapscan
" " 検索語をハイライト表示
set hlsearch
" " ESC連打でハイライト解除
nmap <Esc><Esc> :nohlsearch<CR><Esc>
" vim の矩形選択で文字が無くても右へ進める
set virtualedit=block
" ヤンクでクリップボードにコピー
set clipboard=unnamed,autoselect
" HTML/XML閉じタグ自動補完
augroup MyXML
autocmd!
autocmd Filetype xml inoremap <buffer> </ </<C-x><C-o>
autocmd Filetype html inoremap <buffer> </ </<C-x><C-o>
augroup END

" matchit {{{
" if や for などの文字にも%で移動できるようになる
source $VIMRUNTIME/macros/matchit.vim
let b:match_ignorecase = 1
" }}}

" usability {{{
" set t_Co=256は256色対応のターミナルソフトでのみ作用するので、Winのコマンドプロンプト使っている人などは ダブルコーテーションでコメントアウトしといて
set t_Co=256
" 色づけを on にする
syntax on
" ターミナルの右端で文字を折り返さない
set nowrap

" カーソル位置が右下に表示される
set ruler
" コマンドライン補完が強力になる
set wildmenu

" インサートモードの時に C-j でノーマルモードに戻る
imap <C-j> <esc>
" [ って打ったら [] って入力されてしかも括弧の中にいる(以下同様)
imap [ []<left>
imap ( ()<left>
imap { {}<left>


let s:dein_dir = expand('~/.vim/dein')
let s:dein_repo_dir = s:dein_dir . '/repos/github.com/Shougo/dein.vim'
if &compatible
set nocompatible
endif
if !isdirectory(s:dein_repo_dir)
execute '!git clone git@github.com:Shougo/dein.vim.git' s:dein_repo_dir
endif
execute 'set runtimepath^=' . s:dein_repo_dir
call dein#begin(s:dein_dir)
call dein#add('Shougo/dein.vim')
call dein#add('Shougo/neocomplete.vim')
call dein#add('Shougo/unite.vim')
call dein#add('scrooloose/nerdtree')
call dein#add('jistr/vim-nerdtree-tabs')
call dein#add('Xuyuanp/nerdtree-git-plugin')
call dein#add('airblade/vim-gitgutter')
call dein#add('itchyny/lightline.vim')
"call dein#add('joshdick/onedark.vim')
call dein#add('w0ng/vim-hybrid')
call dein#add('ajh17/Spacegray.vim')
call dein#add('junegunn/fzf.vim')
call dein#add('junegunn/fzf')
call dein#add('bronson/vim-trailing-whitespace')
call dein#add('Yggdroot/indentLine')
call dein#add('ctrlpvim/ctrlp.vim')
call dein#add('thinca/vim-quickrun')
call dein#add('Shougo/neosnippet.vim')
call dein#add('Shougo/neosnippet-snippets')
call dein#add('ternjs/tern', { 'build': {'others': 'npm install' }})

call dein#end()

if dein#check_install()
call dein#install()
endif

filetype plugin indent on

" One Darkを有効にするために必要
"let g:onedark_termcolors=16

" カラースキーマを宣言する
colorscheme hybrid
set background=dark
" ファイル保存時に余分なスペースを削除する
autocmd BufWritePre * :FixWhitespace
" 検索モードを開く
nmap <Leader>f :CtrlP<CR>
" エディタの分割方向を設定する
set splitbelow
set splitright

nnoremap <silent><C-e> :NERDTreeToggle<CR>

"autocmd vimenter * NERDTree

" Enable omni completion.
autocmd FileType css setlocal omnifunc=csscomplete#CompleteCSS
autocmd FileType html,markdown setlocal omnifunc=htmlcomplete#CompleteTags
autocmd FileType javascript setlocal omnifunc=javascriptcomplete#CompleteJS
autocmd FileType xml setlocal omnifunc=xmlcomplete#CompleteTags

""====================neocomplcache====================
"" ~Disable AutoComplPop. neocomplcashe~
"let g:acp_enableAtStartup = 0
"" Use neocomplcache.
"let g:neocomplcache_enable_at_startup = 1
"" " Use smartcase.
"let g:neocomplcache_enable_smart_case = 1
"" " Set minimum syntax keyword length.
"let g:neocomplcache_min_syntax_length = 3
"let g:neocomplcache_lock_buffer_name_pattern = '\*ku\*'
""
"" Define dictionary.
"let g:neocomplcache_dictionary_filetype_lists = {
"\ 'default' : ''
"\ }
"
"" Plugin key-mappings.
"inoremap <expr><C-g>     neocomplcache#undo_completion()
"inoremap <expr><C-l>     neocomplcache#complete_common_string()
"
"let g:neosnippet#snippets_directory='~/.vim/dein/repos/github.com/Shougo/neosnippet-snippets/snippets/'
"

"====================neosnippet====================
"" Plugin key-mappings.
" Note: It must be "imap" and "smap".  It uses <Plug> mappings.
"imap <C-k>     <Plug>(neosnippet_expand_or_jump)
"smap <C-k>     <Plug>(neosnippet_expand_or_jump)
"xmap <C-k>     <Plug>(neosnippet_expand_target)
"
"" SuperTab like snippets behavior.
"" Note: It must be "imap" and "smap".  It uses <Plug> mappings.
"imap <C-k>     <Plug>(neosnippet_expand_or_jump)
""imap <expr><TAB>
"" \ pumvisible() ? "\<C-n>" :
"" \ neosnippet#expandable_or_jumpable() ?
"" \    "\<Plug>(neosnippet_expand_or_jump)" : "\<TAB>"
"smap <expr><TAB> neosnippet#expandable_or_jumpable() ?
"\ "\<Plug>(neosnippet_expand_or_jump)" : "\<TAB>"
"
"" For conceal markers.
"if has('conceal')
"    set conceallevel=2 concealcursor=niv
"endif
"
"" ~ファイルタイプ毎 & gitリポジトリ毎にtagsの読み込みpathを変える~
"function! ReadTags(type)
"    try
"    execute "set tags=".$HOME."/dotfiles/tags_files/".
"        \ system("cd " . expand('%:p:h') . "; basename `git rev-parse --show-toplevel` | tr -d '\n'").
"        \ "/" . a:type . "_tags"
"    catch
"        execute "set tags=./tags/" . a:type. "_tags;"
"    endtry
"endfunction
"
"augroup TagsAutoCmd
"    autocmd!
"    autocmd BufEnter *:call ReadTags(&filetype)
"augroup END


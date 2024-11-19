PGDMP      #            
    |            link-project    16.3    16.3 6    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    17049    link-project    DATABASE     y   CREATE DATABASE "link-project" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'es_MX.utf8';
    DROP DATABASE "link-project";
                postgres    false            �            1259    17051    usuario    TABLE     �  CREATE TABLE public.usuario (
    id_usuario integer NOT NULL,
    nombres character varying(100) NOT NULL,
    apellido_pat character varying(50) NOT NULL,
    apellido_mat character varying(50) NOT NULL,
    num_tel character varying(15) NOT NULL,
    correo character varying(128) NOT NULL,
    clave character varying(255) NOT NULL,
    codigo_escolar character varying(9) NOT NULL,
    activo boolean DEFAULT true,
    foto bytea
);
    DROP TABLE public.usuario;
       public         heap    postgres    false            �            1259    17073    asesor    TABLE     b   CREATE TABLE public.asesor (
    departamento character varying(255)
)
INHERITS (public.usuario);
    DROP TABLE public.asesor;
       public         heap    postgres    false    216            �            1259    17066 
   estudiante    TABLE        CREATE TABLE public.estudiante (
    carrera character varying(50) NOT NULL,
    habilidades text
)
INHERITS (public.usuario);
    DROP TABLE public.estudiante;
       public         heap    postgres    false    216            �            1259    17093 
   integrante    TABLE     {   CREATE TABLE public.integrante (
    integrante_id integer NOT NULL,
    estudiante_id integer,
    proyecto_id integer
);
    DROP TABLE public.integrante;
       public         heap    postgres    false            �            1259    17092    integrante_integrante_id_seq    SEQUENCE     �   CREATE SEQUENCE public.integrante_integrante_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE public.integrante_integrante_id_seq;
       public          postgres    false    222            �           0    0    integrante_integrante_id_seq    SEQUENCE OWNED BY     ]   ALTER SEQUENCE public.integrante_integrante_id_seq OWNED BY public.integrante.integrante_id;
          public          postgres    false    221            �            1259    17112    lider    TABLE     q   CREATE TABLE public.lider (
    lider_id integer NOT NULL,
    estudiante_id integer,
    proyecto_id integer
);
    DROP TABLE public.lider;
       public         heap    postgres    false            �            1259    17111    lider_lider_id_seq    SEQUENCE     �   CREATE SEQUENCE public.lider_lider_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.lider_lider_id_seq;
       public          postgres    false    224            �           0    0    lider_lider_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.lider_lider_id_seq OWNED BY public.lider.lider_id;
          public          postgres    false    223            �            1259    17081    proyecto    TABLE     �  CREATE TABLE public.proyecto (
    id integer NOT NULL,
    nombre character varying(128) NOT NULL,
    descripcion text NOT NULL,
    area character varying(128) NOT NULL,
    cupos smallint DEFAULT 3,
    activo boolean DEFAULT true,
    conocimientos_requeridos text,
    nivel_de_innovacion character varying(20),
    logo bytea,
    CONSTRAINT proyecto_cupos_check CHECK ((cupos <= 3))
);
    DROP TABLE public.proyecto;
       public         heap    postgres    false            �            1259    17130    proyecto_asesor    TABLE     j   CREATE TABLE public.proyecto_asesor (
    proyecto_id integer NOT NULL,
    asesor_id integer NOT NULL
);
 #   DROP TABLE public.proyecto_asesor;
       public         heap    postgres    false            �            1259    17080    proyecto_id_seq    SEQUENCE     �   CREATE SEQUENCE public.proyecto_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.proyecto_id_seq;
       public          postgres    false    220            �           0    0    proyecto_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.proyecto_id_seq OWNED BY public.proyecto.id;
          public          postgres    false    219            �            1259    17050    usuario_id_usuario_seq    SEQUENCE     �   CREATE SEQUENCE public.usuario_id_usuario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.usuario_id_usuario_seq;
       public          postgres    false    216            �           0    0    usuario_id_usuario_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.usuario_id_usuario_seq OWNED BY public.usuario.id_usuario;
          public          postgres    false    215            �           2604    17076    asesor id_usuario    DEFAULT     w   ALTER TABLE ONLY public.asesor ALTER COLUMN id_usuario SET DEFAULT nextval('public.usuario_id_usuario_seq'::regclass);
 @   ALTER TABLE public.asesor ALTER COLUMN id_usuario DROP DEFAULT;
       public          postgres    false    215    218            �           2604    17077    asesor activo    DEFAULT     E   ALTER TABLE ONLY public.asesor ALTER COLUMN activo SET DEFAULT true;
 <   ALTER TABLE public.asesor ALTER COLUMN activo DROP DEFAULT;
       public          postgres    false    218            �           2604    17069    estudiante id_usuario    DEFAULT     {   ALTER TABLE ONLY public.estudiante ALTER COLUMN id_usuario SET DEFAULT nextval('public.usuario_id_usuario_seq'::regclass);
 D   ALTER TABLE public.estudiante ALTER COLUMN id_usuario DROP DEFAULT;
       public          postgres    false    215    217            �           2604    17070    estudiante activo    DEFAULT     I   ALTER TABLE ONLY public.estudiante ALTER COLUMN activo SET DEFAULT true;
 @   ALTER TABLE public.estudiante ALTER COLUMN activo DROP DEFAULT;
       public          postgres    false    217            �           2604    17096    integrante integrante_id    DEFAULT     �   ALTER TABLE ONLY public.integrante ALTER COLUMN integrante_id SET DEFAULT nextval('public.integrante_integrante_id_seq'::regclass);
 G   ALTER TABLE public.integrante ALTER COLUMN integrante_id DROP DEFAULT;
       public          postgres    false    222    221    222            �           2604    17115    lider lider_id    DEFAULT     p   ALTER TABLE ONLY public.lider ALTER COLUMN lider_id SET DEFAULT nextval('public.lider_lider_id_seq'::regclass);
 =   ALTER TABLE public.lider ALTER COLUMN lider_id DROP DEFAULT;
       public          postgres    false    224    223    224            �           2604    17084    proyecto id    DEFAULT     j   ALTER TABLE ONLY public.proyecto ALTER COLUMN id SET DEFAULT nextval('public.proyecto_id_seq'::regclass);
 :   ALTER TABLE public.proyecto ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    220    219    220            �           2604    17054    usuario id_usuario    DEFAULT     x   ALTER TABLE ONLY public.usuario ALTER COLUMN id_usuario SET DEFAULT nextval('public.usuario_id_usuario_seq'::regclass);
 A   ALTER TABLE public.usuario ALTER COLUMN id_usuario DROP DEFAULT;
       public          postgres    false    215    216    216            �          0    17073    asesor 
   TABLE DATA           �   COPY public.asesor (id_usuario, nombres, apellido_pat, apellido_mat, num_tel, correo, clave, codigo_escolar, activo, foto, departamento) FROM stdin;
    public          postgres    false    218   [B       �          0    17066 
   estudiante 
   TABLE DATA           �   COPY public.estudiante (id_usuario, nombres, apellido_pat, apellido_mat, num_tel, correo, clave, codigo_escolar, activo, foto, carrera, habilidades) FROM stdin;
    public          postgres    false    217   8C       �          0    17093 
   integrante 
   TABLE DATA           O   COPY public.integrante (integrante_id, estudiante_id, proyecto_id) FROM stdin;
    public          postgres    false    222   .D       �          0    17112    lider 
   TABLE DATA           E   COPY public.lider (lider_id, estudiante_id, proyecto_id) FROM stdin;
    public          postgres    false    224   KD       �          0    17081    proyecto 
   TABLE DATA           �   COPY public.proyecto (id, nombre, descripcion, area, cupos, activo, conocimientos_requeridos, nivel_de_innovacion, logo) FROM stdin;
    public          postgres    false    220   hD       �          0    17130    proyecto_asesor 
   TABLE DATA           A   COPY public.proyecto_asesor (proyecto_id, asesor_id) FROM stdin;
    public          postgres    false    225   7E       �          0    17051    usuario 
   TABLE DATA           �   COPY public.usuario (id_usuario, nombres, apellido_pat, apellido_mat, num_tel, correo, clave, codigo_escolar, activo, foto) FROM stdin;
    public          postgres    false    216   TE       �           0    0    integrante_integrante_id_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('public.integrante_integrante_id_seq', 4, true);
          public          postgres    false    221            �           0    0    lider_lider_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.lider_lider_id_seq', 2, true);
          public          postgres    false    223            �           0    0    proyecto_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.proyecto_id_seq', 3, true);
          public          postgres    false    219            �           0    0    usuario_id_usuario_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.usuario_id_usuario_seq', 11, true);
          public          postgres    false    215            �           2606    17100 3   integrante integrante_estudiante_id_proyecto_id_key 
   CONSTRAINT     �   ALTER TABLE ONLY public.integrante
    ADD CONSTRAINT integrante_estudiante_id_proyecto_id_key UNIQUE (estudiante_id, proyecto_id);
 ]   ALTER TABLE ONLY public.integrante DROP CONSTRAINT integrante_estudiante_id_proyecto_id_key;
       public            postgres    false    222    222            �           2606    17098    integrante integrante_pkey 
   CONSTRAINT     c   ALTER TABLE ONLY public.integrante
    ADD CONSTRAINT integrante_pkey PRIMARY KEY (integrante_id);
 D   ALTER TABLE ONLY public.integrante DROP CONSTRAINT integrante_pkey;
       public            postgres    false    222            �           2606    17119 )   lider lider_estudiante_id_proyecto_id_key 
   CONSTRAINT     z   ALTER TABLE ONLY public.lider
    ADD CONSTRAINT lider_estudiante_id_proyecto_id_key UNIQUE (estudiante_id, proyecto_id);
 S   ALTER TABLE ONLY public.lider DROP CONSTRAINT lider_estudiante_id_proyecto_id_key;
       public            postgres    false    224    224            �           2606    17117    lider lider_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.lider
    ADD CONSTRAINT lider_pkey PRIMARY KEY (lider_id);
 :   ALTER TABLE ONLY public.lider DROP CONSTRAINT lider_pkey;
       public            postgres    false    224            �           2606    17134 $   proyecto_asesor proyecto_asesor_pkey 
   CONSTRAINT     v   ALTER TABLE ONLY public.proyecto_asesor
    ADD CONSTRAINT proyecto_asesor_pkey PRIMARY KEY (proyecto_id, asesor_id);
 N   ALTER TABLE ONLY public.proyecto_asesor DROP CONSTRAINT proyecto_asesor_pkey;
       public            postgres    false    225    225            �           2606    17091    proyecto proyecto_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.proyecto
    ADD CONSTRAINT proyecto_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.proyecto DROP CONSTRAINT proyecto_pkey;
       public            postgres    false    220            �           2606    17065 "   usuario usuario_codigo_escolar_key 
   CONSTRAINT     g   ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_codigo_escolar_key UNIQUE (codigo_escolar);
 L   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_codigo_escolar_key;
       public            postgres    false    216            �           2606    17063    usuario usuario_correo_key 
   CONSTRAINT     W   ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_correo_key UNIQUE (correo);
 D   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_correo_key;
       public            postgres    false    216            �           2606    17061    usuario usuario_num_tel_key 
   CONSTRAINT     Y   ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_num_tel_key UNIQUE (num_tel);
 E   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_num_tel_key;
       public            postgres    false    216            �           2606    17059    usuario usuario_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id_usuario);
 >   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_pkey;
       public            postgres    false    216            �           2606    17101 (   integrante integrante_estudiante_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.integrante
    ADD CONSTRAINT integrante_estudiante_id_fkey FOREIGN KEY (estudiante_id) REFERENCES public.usuario(id_usuario) ON DELETE CASCADE;
 R   ALTER TABLE ONLY public.integrante DROP CONSTRAINT integrante_estudiante_id_fkey;
       public          postgres    false    216    3297    222            �           2606    17106 &   integrante integrante_proyecto_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.integrante
    ADD CONSTRAINT integrante_proyecto_id_fkey FOREIGN KEY (proyecto_id) REFERENCES public.proyecto(id) ON DELETE CASCADE;
 P   ALTER TABLE ONLY public.integrante DROP CONSTRAINT integrante_proyecto_id_fkey;
       public          postgres    false    220    3299    222            �           2606    17120    lider lider_estudiante_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.lider
    ADD CONSTRAINT lider_estudiante_id_fkey FOREIGN KEY (estudiante_id) REFERENCES public.usuario(id_usuario) ON DELETE CASCADE;
 H   ALTER TABLE ONLY public.lider DROP CONSTRAINT lider_estudiante_id_fkey;
       public          postgres    false    3297    216    224            �           2606    17125    lider lider_proyecto_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.lider
    ADD CONSTRAINT lider_proyecto_id_fkey FOREIGN KEY (proyecto_id) REFERENCES public.proyecto(id) ON DELETE CASCADE;
 F   ALTER TABLE ONLY public.lider DROP CONSTRAINT lider_proyecto_id_fkey;
       public          postgres    false    3299    224    220            �           2606    17140 .   proyecto_asesor proyecto_asesor_asesor_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.proyecto_asesor
    ADD CONSTRAINT proyecto_asesor_asesor_id_fkey FOREIGN KEY (asesor_id) REFERENCES public.usuario(id_usuario) ON DELETE CASCADE;
 X   ALTER TABLE ONLY public.proyecto_asesor DROP CONSTRAINT proyecto_asesor_asesor_id_fkey;
       public          postgres    false    225    216    3297            �           2606    17135 0   proyecto_asesor proyecto_asesor_proyecto_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.proyecto_asesor
    ADD CONSTRAINT proyecto_asesor_proyecto_id_fkey FOREIGN KEY (proyecto_id) REFERENCES public.proyecto(id) ON DELETE CASCADE;
 Z   ALTER TABLE ONLY public.proyecto_asesor DROP CONSTRAINT proyecto_asesor_proyecto_id_fkey;
       public          postgres    false    225    220    3299            �   �   x�}�=��0���S�X8NH�@�T�nI3$�d3Q�H�����#�b8@��7i�O�������s��q���e]-�B�
f"d�&V�F�sF6��Q�T�.�EU#�tL����F�Z�(?~G�D��m,�c���}^�e��2�uU��oB:N��u��'$�Ps����,O��Њ����^��a�z�,1�}�*q�B��X{      �   �   x���=N�@���S��b�v�.$"�i&�QX䝵ֻR��p *����"3�<}߼�H�7g�;Yj�!�VyQ�7��]T�x�W�m�J;����B��{����-X�ζ1�6���$�Njτ'�z�����d[�U�Y����7�8ո�o��e1g�Y�b4�6���G
l��`4u���=|�0>;-Ж�h�u*�e���E�
匽i�D�2�9�$I~ 4�iR      �      x������ � �      �      x������ � �      �   �   x�U�1N�@E��)��HN�Q�H�D�u���@<��-QrJ�v/�Mh"������E9����ב0&�??�'¤��(�:�Q�:/ ���� ;p�ni��<R�VÓ\Xl�;O�����S(y,h�|&�l���V�T��1,/��}�ʜX���Y��\�m���,�Y�~���.�k��4M�ATO      �      x������ � �      �      x������ � �     
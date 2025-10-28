# Changelog - JS Jobs Manager Custom

## Version 2.0.2-custom (25 octobre 2025)

### Modifications par Keoni Consulting

Ce fork personnalisé du plugin JS Jobs Manager (original par JoomSky) inclut les corrections suivantes pour résoudre des problèmes critiques dans le flux de gestion des CV.

---

### 🐛 Corrections de bugs

#### 1. Page "Ajouter un CV" blanche

**Problème :** La page `/addresume` renvoyait une page blanche en raison de clés de configuration manquantes après réinstallation.

**Solution :**

- Ajout de valeurs par défaut (fallback) dans `js-jobs/modules/resume/controller.php`
- Les clés `formresume`, `vis_jsformresume`, `visitor_can_add_resume` sont initialisées à `1` si absentes
- Fichier modifié : `modules/resume/controller.php` (case `'addresume'`)

---

#### 2. Formulaire CV inutilisable (erreurs JavaScript)

**Problème :** Scripts manquants, liens HTTP bloqués par HTTPS, erreurs console empêchant la soumission.

**Solutions :**

- Restauration complète de `includes/js/chosen/chosen.jquery.min.js`
- Correction des URLs HTTP → HTTPS dans `includes/css/status_graph.css`
- Vérification de l'ordre de chargement des dépendances JS

**Fichiers modifiés :**

- `includes/js/chosen/chosen.jquery.min.js`
- `includes/css/status_graph.css`

---

#### 3. Liste "Mes CV" vide après sauvegarde

**Problème :** Les CV enregistrés n'apparaissaient pas car stockés avec `uid=0` (pas de lien utilisateur JS Jobs).

**Solutions :**

- **Fallback par email** dans `getMyResumes()` : recherche par `resume.email_address` si `uid` ne renvoie rien
- **Mise à jour automatique des uid** : lors du chargement de la liste, les CV avec `uid=0` sont liés automatiquement à l'utilisateur connecté
- **Pagination recalculée** selon le total trouvé (uid ou email)
- **Diagnostics console** ajoutés pour suivi : `debug_myresumes`, `uidPatchedCount`

**Fichiers modifiés :**

- `modules/resume/model.php` (fonction `getMyResumes()`)
- `modules/resume/tmpl/myresumes.php` (logs console)

---

#### 4. Erreur "Oops... You are not allowed"

**Problème :** Impossible d'ouvrir ou modifier un CV car la vérification de propriété (`getIfResumeOwner()`) ne contrôlait que le `uid`.

**Solutions :**

- **Priorité à la correspondance par email** (case-insensitive) dans `getIfResumeOwner()`
- **Synchronisation automatique** : mise à jour de l'email ET du `uid` lors du premier accès
- **Force l'email utilisateur** dans `storeResume()` pour garantir la cohérence
- **Diagnostics détaillés** : `matchedBy`, `emailUpdated`, `uidUpdated` enregistrés dans options WP

**Fichiers modifiés :**

- `modules/resume/model.php` (fonctions `storeResume()`, `getIfResumeOwner()`)
- `modules/resume/tmpl/viewresume.php` (diagnostics console)
- `modules/resume/controller.php` (paramètre `forceview`)

---

### 🔧 Améliorations techniques

#### Fonction helper ajoutée

- `ensureJsJobsUserForCurrentWpUser($wpUserId)` : crée automatiquement une entrée dans `js_job_users` si manquante pour lier WordPress et JS Jobs

#### Diagnostics de développement

Options WordPress temporaires pour suivi (à supprimer en production) :

- `jsjobs_debug_owner_check`
- `jsjobs_debug_last_uid_fix`
- `jsjobs_debug_last_resolved_uid`
- `jsjobs_debug_uid_insert_error`

Commandes de nettoyage :

```bash
wp option delete jsjobs_debug_owner_check
wp option delete jsjobs_debug_last_uid_fix
wp option delete jsjobs_debug_last_resolved_uid
wp option delete jsjobs_debug_uid_insert_error
```

---

### 📋 Fichiers impactés - Récapitulatif

1. `modules/resume/controller.php` - fallback config, forceview
2. `modules/resume/model.php` - logique principale (storeResume, getMyResumes, getIfResumeOwner, ensureJsJobsUserForCurrentWpUser)
3. `modules/resume/tmpl/myresumes.php` - diagnostics console
4. `modules/resume/tmpl/viewresume.php` - diagnostics console
5. `includes/css/status_graph.css` - corrections HTTPS
6. `includes/js/chosen/chosen.jquery.min.js` - restauration complète
7. `js-jobs.php` - métadonnées plugin (auteur, version, description)

---

### ✅ Résultat final

- ✅ Page "Ajouter un CV" accessible sans page blanche
- ✅ Formulaire CV fonctionnel avec tous les scripts
- ✅ Liste "Mes CV" affiche correctement les entrées
- ✅ Accès aux détails/modification restauré
- ✅ Synchronisation automatique email/uid pour données legacy
- ✅ Diagnostics complets pour debugging

---

### 📝 Notes de compatibilité

- **Version WordPress testée :** 6.8.3
- **PHP minimum :** 5.2.4 (7.1+ recommandé)
- **Base plugin :** JS Jobs Manager 2.0.2 (JoomSky)
- **Licence :** GPLv2 (maintenue)

---

### 🔮 Recommandations futures

1. **Script de migration** : normaliser uid/email pour tous les CV historiques en une seule opération
2. **Retrait des diagnostics console** en production pour optimiser les performances
3. **Tests automatisés** (PHPUnit/Playwright) pour vérifier le flux complet création/affichage CV
4. **Configuration post-installation** : s'assurer que les clés `formresume`, `vis_jsformresume`, `visitor_can_add_resume` sont initialisées lors de l'activation

---

### 📞 Support

Pour toute question concernant ces modifications :

- **Auteur des modifications :** Keoni Consulting
- **Site web :** https://keoni-consulting.net/
- **Plugin original :** JoomSky (http://www.joomsky.com)

---

### ⚖️ Licence

Ce travail dérivé conserve la licence GPLv2 du plugin original.
Toutes les modifications sont documentées et le code source reste ouvert conformément aux termes de la GPL.
